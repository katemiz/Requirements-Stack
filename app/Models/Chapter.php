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
        'ordering',
        'title',
    ];




    public function getProjectNameAttribute()
    {
        return Project::find($this->project_id)->code;
    }


    public function getEndProductNameAttribute()
    {
        if ($this->endproduct_id) {
            return Endproduct::find($this->endproduct_id)->code;

        } else {
            return null;
        }
    }



}
