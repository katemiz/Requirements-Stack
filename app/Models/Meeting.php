<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','project_id', 'code','name'];

    public function verification(): BelongsTo
    {
        return $this->belongsToMany(Verification::class,'id','meeting_id');
    }
}
