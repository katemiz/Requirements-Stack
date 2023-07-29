<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


use App\Models\Endproduct;
use App\Models\Verification;
use App\Models\Meeting;



class Requirement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','project_id','text','rtype','remarks','cross_ref_no'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function endproducts(): BelongsToMany
    {
        return $this->belongsToMany(Endproduct::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class);
    }


    public function dgates(): HasMany
    {
        return $this->hasMany(Meeting::class,'verifications');
    }

}
