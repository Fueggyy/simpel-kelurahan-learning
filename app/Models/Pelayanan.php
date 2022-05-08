<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    use HasFactory;

    protected $table = 'pelayanan';
 
    protected $fillable = [
        'nomor', 
        'nik', 
        'name', 
        'address',
        'jenis_pelayanan_id' 
    ];

    public function jenis_pelayanan()
    {
        return $this->hasOne(\App\Models\JenisPelayanan::class, 'id','jenis_pelayanan_id');
    }

}
