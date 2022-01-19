<?php

namespace App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property int $role_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\Role $role
 * @property \Illuminate\Support\Collection $applications
 */
class User extends Authenticatable
{
    use Notifiable,
        HasFactory,
        HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get only manager users
     *
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public static function getOnlyManagers(): Collection
    {
        return static::query()
            ->where([
                'role_id' => Role::manager()->id,
            ])
            ->get();
    }

    /**
     * Check if current user has manager role
     *
     * @return bool
     * @throws Exception
     */
    public function isManager(): bool
    {
        return $this->role_id && $this->role_id == Role::manager()?->id;
    }

    /**
     * Check if current user has client role
     *
     * @return bool
     * @throws Exception
     */
    public function isClient(): bool
    {
        return $this->role_id && $this->role_id == Role::client()?->id;
    }

    /**
     * Modify password field before storing it ro db
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
