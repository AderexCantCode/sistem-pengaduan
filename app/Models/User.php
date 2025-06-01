<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's name (accessor for nama field)
     */
    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class, 'admin_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function hasVoted($pengaduan, $type)
    {
        return $pengaduan->votes()
            ->where('user_id', $this->id)
            ->where('type', $type)
            ->exists();
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }
}
