<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananDetail extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_detail';
 
    protected $fillable = [
        'pelayanan_id', 
        'document_id', 
    ];
}
