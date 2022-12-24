<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $gravatar
 * @property \Carbon $email_verified_at
 * @property \Carbon $created_at
 * @property \Carbon $updated_at
 * @property \Post[] $posts
 * @property \User[] $following
 * @property \User[] $followers
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
        'email', 'email_verified_at', 'created_at', 'updated_at',
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
     * The attributes that should be appended for arrays.
     *
     * @var array
     */
    protected $appends = [
        'gravatar',
    ];

    public function getGravatarAttribute()
    {
        $hash = md5($this->email);
        return "https://www.gravatar.com/avatar/$hash?s=256&d=mp";
    }

    /**
     * The posts created by the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * The users this user is following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'user_id', 'followed_user_id');
    }

    /**
     * The users following this user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'followed_user_id', 'user_id');
    }

    /**
     * Check if this user is following another user.
     */
    public function isFollowing(User $user): bool
    {
        return $this->following()
            ->newPivotStatement()
            ->where('user_id', $this->id)
            ->where('followed_user_id', $user->id)
            ->count() ? true : false;
    }

    /**
     * Hide any attributes that should be private.
     */
    public function hidePrivateAttributes()
    {
        return $this->makeHidden([
            'email', 'email_verified_at', 'created_at', 'updated_at',
        ]);
    }
}
