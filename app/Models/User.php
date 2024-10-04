<?php

namespace App\Models;

use App\Traits\Friendable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Searchable;
    use Friendable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
        'email_verified_at' => 'datetime',
        ];
    }


    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function friendsRequested()
    {
        return $this->belongsToMany(User::class, 'friends', 'requester_id', 'user_requested_id')
            ->withPivot('status');
    }

    public function friendsReceived()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_requested_id', 'requester_id')
            ->withPivot('status');
    }

    public function friends()
    {
        return $this->friendsRequested->merge($this->friendsReceived);
    }
    /**
     * Get all of the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }


    public function showRoute($parameters = []) 
    {
        return route('profiles.show', [$this, Str::slug($this->name), ...$parameters]);
    }

    public function defaultProfilePhotoUrl() 
    {
        return asset('/storage/images/default-avatar.jpg');
    }

}
