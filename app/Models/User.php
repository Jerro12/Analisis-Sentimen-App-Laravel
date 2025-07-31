<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_url', // Tambahkan ini
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's profile photo URL or generate default avatar
     */
    public function getProfilePhotoAttribute(): string
    {
        // Jika user punya foto profil
        if ($this->profile_photo_url) {
            // Jika URL lengkap (dari Google OAuth)
            if (filter_var($this->profile_photo_url, FILTER_VALIDATE_URL)) {
                return $this->profile_photo_url;
            }
            // Jika path lokal dan file exists
            if (Storage::disk('public')->exists(str_replace('storage/', '', $this->profile_photo_url))) {
                return asset($this->profile_photo_url);
            }
        }

        // Generate default avatar menggunakan UI Avatars
        return $this->generateDefaultAvatar();
    }

    /**
     * Generate default avatar URL
     */
    public function generateDefaultAvatar(): string
    {
        // Gunakan default avatar dari public/images/default-avatar.png
        return asset('images/default-avatar.png');
    }

    /**
     * Delete old profile photo when updating
     */
    public function deleteOldProfilePhoto(): void
    {
        if ($this->profile_photo_url && !filter_var($this->profile_photo_url, FILTER_VALIDATE_URL)) {
            $path = str_replace('storage/', '', $this->profile_photo_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relasi ke bookmarks (novel-novel yang dibookmark user)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmarks()
    {
        return $this->belongsToMany(Novel::class, 'bookmarks')->withTimestamps();
    }
}
