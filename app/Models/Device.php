<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['category'];

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function comments()
//    {
//        return $this->hasMany(Comment::class);
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function category()
//    {
//        return $this->belongsTo(Category::class);
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function author()
//    {
//        return $this->belongsTo(User::class, 'user_id');
//    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function editedBy()
    {
        return $this->belongsTo(User::class, 'edited_by_id');
    }
}
