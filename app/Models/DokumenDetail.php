<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenDetail extends Model
{
    use HasFactory;

    protected $table = 'document_detail';
 
    protected $fillable = [
        'type_id', 
        'document_id', 
    ];
}
