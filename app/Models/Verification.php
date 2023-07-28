<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Verification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','project_id','requirement_id','meeting_id','moc_id','poc_id','witness_id','remarks'];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }




    public function dgate(): HasMany
    {
        return $this->hasMany(Meeting::class,'verifications');
    }



}
