<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["name", "description", "price", "image", "category", "user_id", "is_active"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "id" => "integer",
            "price" => "decimal:2",
        ];
    }

    /**
     * Get the image URL attribute
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset("storage/" . $this->image);
        }
        return null;
    }

    /**
     * Check if product has image
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return !empty($this->image) &&
            Storage::disk("public")->exists($this->image);
    }

    /**
     * Get the comments for the product
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    /**
     * Get the user that owns the product
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
