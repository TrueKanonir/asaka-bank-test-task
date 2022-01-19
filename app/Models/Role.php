<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Role
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Role extends Model
{
    use HasFactory;

    /** @var string[] */
    public const DEFAULT = [
        'manager' => 'manager',
        'client' => 'client',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [];

    /**
     * The model's attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [];

    /**
     * Find role by given slug
     *
     * @param string $slug
     * @return self|\Illuminate\Database\Eloquent\Model
     */
    public static function findBySlug(string $slug): self | Model
    {
        return static::query()
            ->where(['slug' => $slug])
            ->firstOrFail();
    }

    /**
     * Get manager instance
     *
     * @return null|self|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public static function manager(): null | self | Model
    {
        return static::getCached()
            ->first(fn(Role $role) => $role->slug == Role::DEFAULT['manager']);
    }

    /**
     * Get client instance
     *
     * @return null|self|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public static function client(): null | self | Model
    {
        return static::getCached()
            ->first(fn(Role $role) => $role->slug == Role::DEFAULT['client']);
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public static function getCached(): Collection
    {
        return cache()
            ->rememberForever(
                Str::lower(class_basename(static::class)),
                function () {
                    return static::all();
                });
    }

    /**
     * Modify slug attribute before storing it to db
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute(string $value): void
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}
