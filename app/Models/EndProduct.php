<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class EndProduct extends Model
{
    use HasFactory;

    protected $table = 'end_products';


    protected $fillable = ['user_id','project_id','code', 'title'];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    // Accessor to get the full name of the user
    public function getProjectCodeAttribute()
    {
        return Project::find($this->project_id)->code;
    }



    public function requirements(): BelongsToMany
    {
        return $this->belongsToMany(Requirement::class);
    }

}
