<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function sektor(){
        return $this->belongsTo(Sektor::class);
    }

    public function proyeks(){
        return $this->hasMany(Proyek::class);
    }
}
