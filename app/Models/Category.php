<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class)->orderBy('order');
    }

    /**
     * @return HasMany
     */
    public function currentDevices()
    {
        return $this->hasMany(Device::class)->with('photos')->orderBy('order');
    }
}
