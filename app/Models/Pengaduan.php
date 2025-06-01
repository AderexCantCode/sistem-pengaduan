<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'isi',
        'status',
        'gambar',
        'upvotes',    // Add these
        'downvotes'   // Add these
    ];

    // Status constants
    const STATUS_TERKIRIM = 'terkirim';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';

    protected $casts = [
        'status' => 'string'
    ];

    // Get all valid status values
    public static function getStatuses(): array
    {
        return [
            self::STATUS_TERKIRIM => 'Terkirim',
            self::STATUS_DIPROSES => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
        ];
    }

    // Helper method to check status
    public function isStatus(string $status): bool
    {
        return $this->status === $status;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    /**
     * Get all votes
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get upvotes relation
     */
    public function upvotes()
    {
        return $this->votes()->where('type', 'upvote');
    }

    /**
     * Get downvotes relation
     */
    public function downvotes()
    {
        return $this->votes()->where('type', 'downvote');
    }

    /**
     * Get total upvotes count
     */
    public function upvotesCount()
    {
        return $this->upvotes()->count();
    }

    /**
     * Get total downvotes count
     */
    public function downvotesCount()
    {
        return $this->downvotes()->count();
    }

    /**
     * Check if user has voted
     */
    public function hasUserVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's vote type
     */
    public function getUserVoteType($userId)
    {
        $vote = $this->userVoteFor($userId);
        return $vote ? $vote->type : null;
    }

    // Add these accessors
    public function getUpvotesAttribute($value)
    {
        return $value ?? $this->upvotes()->count();
    }

    public function getDownvotesAttribute($value)
    {
        return $value ?? $this->downvotes()->count();
    }

    // Update userVoteFor method
    public function userVoteFor($userId)
    {
        return $this->votes()
            ->where('user_id', $userId)
            ->first();
    }
}
