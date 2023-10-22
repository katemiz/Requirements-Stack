<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $table = 'phases';

    protected $fillable = ['user_id','updated_uid','company_id','project_id','endproduct_id','code', 'name','description'];

    public function getProjectNameAttribute()
    {
        return Project::find($this->project_id)->code;
    }
}
