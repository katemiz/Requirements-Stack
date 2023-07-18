<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\EndProduct;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','project_id','text','rtype'];


    public function end_products(): BelongsToMany
    {
        return $this->belongsToMany(EndProduct::class);
    }

}
