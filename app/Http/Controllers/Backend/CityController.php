<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    protected $gemini;
    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $url = $row->image ? url('/uploads/cities/'.$row->image) : 'https://ui-avatars.com/api/?name='.urlencode($row->name).'&background=f1f5f9&color=64748b';
                    return '<div style="display:flex; align-items:center; gap:12px;">
                                <img src="'.$url.'" id="city-img-'.$row->id.'" style="width:50px; height:50px; border-radius:12px; object-fit:cover; border:2px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            </div>';
                })
                ->addColumn('actions', function($row){
                    $btn = '<div style="display:flex; gap:8px;">
                                <button onclick="generateImage('.$row->id.')" id="gen-btn-'.$row->id.'" class="btn" title="Auto-Generate Image" style="background:#ecfdf5; color:#059669; border:1px solid #d1fae5; padding:6px 10px; border-radius:8px;"><i class="fas fa-magic"></i></button>
                                <a href="'.route('admin.city.edit', $row->id).'" class="btn" style="background:#f5f3ff; color:#7c3aed; border:1px solid #ede9fe; padding:6px 10px; border-radius:8px;"><i class="fas fa-edit"></i></a>
                                <a onclick="return confirm(\'Delete this city/hub?\')" href="'.route('admin.city.delete', $row->id).'" class="btn" style="background:#fef2f2; color:#dc2626; border:1px solid #fee2e2; padding:6px 10px; border-radius:8px;"><i class="fas fa-trash-alt"></i></a>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }
        return view('admin.pages.City.list');
    }

    public function create()
    {
        return view('admin.pages.City.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = null;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/cities'), $imageName);
        }

        $city = City::create ([
            'name'=>$request->name,
            'image'=>$imageName,
            'image_hash' => $imageName ? md5_file(public_path('uploads/cities/' . $imageName)) : null
        ]);

        // Automatically generate image if not uploaded
        if (!$imageName) {
            $this->performImageGeneration($city);
        }

        return redirect()->route('admin.city')->with('message','City created successfully!');
    }

    public function cityEdit($id)
    {
        $city = City::find($id);
        if ($city) {
            return view('admin.pages.City.edit',compact('city'));
        }
    }

    public function cityUpdate(Request $request,$id){
        $city = City::find($id);
        if ($city) {
            $imageName = $city->image;
            if($request->hasFile('image')){
                // Remove old image if exists
                if($imageName && file_exists(public_path('uploads/cities/'.$imageName))){
                    unlink(public_path('uploads/cities/'.$imageName));
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('uploads/cities'), $imageName);
            }

            $city->update([
                'name'=>$request->name,
                'image'=>$imageName,
                'image_hash' => $imageName ? md5_file(public_path('uploads/cities/' . $imageName)) : $city->image_hash
            ]);
            return redirect()->route('admin.city')->with('success','City Updated!');
        }
    }

    public function cityDelete($city_id)
    {
        City::find($city_id)->delete();
        return redirect()->route('admin.city')->with('msg','City Deleted.');
    }

    public function generateImage($id)
    {
        $city = City::find($id);
        if (!$city) return response()->json(['success' => false, 'message' => 'City not found'], 404);

        if ($this->performImageGeneration($city)) {
            $url = url('/uploads/cities/' . $city->image);
            return response()->json([
                'success' => true,
                'message' => 'Image generated successfully!',
                'image_url' => $url
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Could not generate image.'], 500);
    }

    public function generateAllMissing()
    {
        // Return list of cities needing images so JS can process them
        $cities = City::whereNull('image')->get(['id', 'name']);
        return response()->json($cities);
    }

    private function performImageGeneration($city, $retryCount = 0)
    {
        if ($retryCount > 3) {
            Log::error("Max retries exceeded for {$city->name} image generation.");
            return false;
        }

        // Generate actual image URL using Gemini Imagen 3 (Exclusively)
        $imageUrl = $this->gemini->generateImage($city->name);

        if (empty($imageUrl)) {
            Log::error("Gemini failed to generate image URL for {$city->name}");
            return false;
        }

        try {
            $imageContent = null;
            if (str_starts_with($imageUrl, 'data:image')) {
                // Handle base64 data (Gemini Imagen)
                $data = explode(',', $imageUrl);
                if (isset($data[1])) {
                    $imageContent = base64_decode($data[1]);
                }
            } else {
                // Handle URL (DALL-E 3)
                $response = Http::timeout(60)->get($imageUrl);
                if ($response->successful()) {
                    $imageContent = $response->body();
                } else {
                    Log::warning("Failed to download AI image from URL: {$imageUrl}");
                }
            }

            if ($imageContent) {
                // Calculate md5 hash for uniqueness
                $hash = md5($imageContent);
                $isDuplicate = City::where('image_hash', $hash)->exists();

                if ($isDuplicate) {
                    Log::info("Duplicate AI image detected for {$city->name}, retrying...");
                    return $this->performImageGeneration($city, $retryCount + 1);
                }

                $imageName = time() . '_' . uniqid() . '_ai.jpg';
                $path = public_path('uploads/cities');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                file_put_contents($path . '/' . $imageName, $imageContent);

                if ($city->image && file_exists($path . '/' . $city->image)) {
                    @unlink($path . '/' . $city->image);
                }

                $city->update([
                    'image' => $imageName,
                    'image_hash' => $hash
                ]);
                return true;
            } else {
                Log::warning("Failed to download AI image from Gemini URL: {$imageUrl}");
            }
        } catch (\Exception $e) {
            Log::error('Image generation failed for ' . $city->name . ': ' . $e->getMessage());
        }

        return false;
    }
}
