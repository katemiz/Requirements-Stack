<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Verification extends Model
{
    use HasFactory;

    //protected $fillable = ['user_id','project_id','requirement_id','rtype','remarks','cross_ref_no'];


    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }
}
