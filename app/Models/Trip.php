<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;

class Trip extends Model
{
    use HasFactory;
    protected $table='trips';
    protected $guarded=[];

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::Class);
    }
}