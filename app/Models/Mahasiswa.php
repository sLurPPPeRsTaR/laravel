<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    
    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'prodi',
        'angkatan'
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mahasiswa_id');
    }
}
