<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'updated_uid',
        'company_id',
        'project_id',
        'endproduct_id',
        'chapter_id',
        'requirement_no',
        'revision',
        'is_latest',
        'cross_ref_no',
        'title',
        'text',
        'rtype',
        'source',
        'remarks',
        'status',
    ];

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


    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class,'model_item_id')->where(['model_name'=>'requirement']);
    }


    public function dgates(): HasMany
    {
        return $this->hasMany(Gate::class,'verifications');
    }


    public function getProjectNameAttribute()
    {
        return Project::find($this->project_id)->code;
    }

    public function getChapterTitleAttribute()
    {
        if ($this->chapter_id > 0) {
            return Chapter::find($this->chapter_id)->title;
        }

        return 'No related chapter';
    }


    public function getEndProductNameAttribute()
    {
        return Endproduct::find($this->endproduct_id)->code;
    }


    public function getFullNoAttribute()
    {
        //return $this->rtype.'-'.$this->requirement_no.' R'.$this->revision;
        return 'R'.$this->requirement_no.'R'.$this->revision;

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

    public function tests()
    {
        return $this->belongsToMany(Test::class)->withTimestamps();
    }


}
