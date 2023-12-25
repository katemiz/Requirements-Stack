<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poc extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','updated_uid','company_id', 'project_id','endproduct_id','code','name','description'];

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

    public function getCreatedByNameAttribute()
    {
        $usr = User::find($this->user_id);
        return $usr->name.' '.$usr->lastname;
    }

    public function getUpdatedByNameAttribute()
    {
        $usr = User::find($this->updated_uid);
        return $usr->name.' '.$usr->lastname;
    }

}
