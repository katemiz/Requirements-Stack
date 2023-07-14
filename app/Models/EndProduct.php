<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndProduct extends Model
{
    use HasFactory;

    protected $table = 'end_products';


    protected $fillable = ['user_id','project_id','code', 'title'];

}
