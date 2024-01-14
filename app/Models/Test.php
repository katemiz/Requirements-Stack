<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;


use Illuminate\Support\Str;

class Test extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'updated_uid',
        'company_id',
        'project_id',
        'endproduct_id',
        'requirement_no',
        'test_no',
        'title',
        'revision',
        'is_latest',
        'test_type',
        'remarks',
        'status',
    ];




    public function getFullTestNoAttribute()
    {
        return 'T'.$this->test_no.' R'.$this->revision;
    }


    public function requirements(): BelongsToMany
    {
        return $this->belongsToMany(Requirement::class);
    }

}
