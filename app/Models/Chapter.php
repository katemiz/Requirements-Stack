<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'updated_uid',
        'company_id',
        'project_id',
        'endproduct_id',
        'title',
    ];
}
