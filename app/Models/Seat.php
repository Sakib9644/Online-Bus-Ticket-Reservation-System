<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;

class Seat extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}

