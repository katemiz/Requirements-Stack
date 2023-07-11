<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','company_id','code', 'title'];


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function endproducts(): HasMany
    {
        return $this->hasMany(EndProduct::class);
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class);
    }


}
