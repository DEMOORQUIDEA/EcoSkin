<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ["name", "email", "password", "avatar", "is_active"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    /**
     * Get the avatar URL attribute
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar) {
            return asset("storage/" . $this->avatar);
        }
        return null;
    }

    /**
     * Check if user has avatar
     *
     * @return bool
     */
    public function hasAvatar(): bool
    {
        return !empty($this->avatar) &&
            \Illuminate\Support\Facades\Storage::disk("public")->exists($this->avatar);
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is cliente
     *
     * @return bool
     */
    public function isCliente(): bool
    {
        return $this->hasRole('cliente');
    }

    /**
     * Check if user is vendedor
     *
     * @return bool
     */
    public function isVendedor(): bool
    {
        return $this->hasRole('vendedor');
    }

    /**
     * Check if user is invitado
     *
     * @return bool
     */
    public function isInvitado(): bool
    {
        return $this->hasRole('invitado');
    }

    /**
     * Get user's primary role name
     *
     * @return string|null
     */
    public function getPrimaryRole(): ?string
    {
        return $this->getRoleNames()->first();
    }

    /**
     * Get all user roles
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllRoles()
    {
        return $this->getRoleNames();
    }

    /**
     * Check if user is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * Check if user is inactive
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->is_active === false;
    }

    /**
     * Activate user account
     *
     * @return void
     */
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate user account
     *
     * @return void
     */
    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Toggle user status
     *
     * @return void
     */
    public function toggleStatus(): void
    {
        $this->update(['is_active' => !$this->is_active]);
    }

    /**
     * Get the products for the user
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
