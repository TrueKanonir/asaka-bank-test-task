<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Application
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property string $file
 * @property string $attachment
 * @property bool $is_verified
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\User $user
 */
class Application extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'file',
        'is_verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'user_id' => 'int',
        'is_verified' => 'bool',
    ];

    /**
     * The model's attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_verified' => false,
    ];

    /**
     * Check if user already place application today
     *
     * @param int $userId
     * @return bool
     */
    public static function checkIfAlreadyPlaced(int $userId): bool
    {
        return static::query()
            ->where(['user_id' => $userId])
            ->where('created_at', '<', now()->addHour(24))
            ->exists();
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginated(): LengthAwarePaginator
    {
        return static::query()
            ->with('user')
            ->paginate();
    }

    /**
     * Get link to attachment
     *
     * @return string|null
     */
    public function getAttachmentAttribute(): ?string
    {
        if (! $this->file) {
            return null;
        }

        return Storage::url($this->file);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
