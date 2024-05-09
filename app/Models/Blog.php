<?php

namespace App\Models;

use App\Models\Imagable;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];

    /**
     * Get the images for the blog post.
     */
    public function imagables(): HasMany
    {
        return $this->hasMany(Imagable::class);
    }
}
