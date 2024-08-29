<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function mitras()
    {
        return $this->belongsToMany(Mitra::class, 'laporans', 'proyek_id', 'mitra_id')
            ->wherePivot('status', 'diterima')
            ->distinct();
    }
}
