<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['category'];

    /**
     * @param $query
     * @param array $filter
     * @return void
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['currentCategory'] ?? false, fn($query, $category) => $query->whereHas('category', fn($query) => $query->where('id', $category->id))
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editedBy()
    {
        return $this->belongsTo(User::class, 'edited_by_id');
    }
}
