<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image_url'
    ];

    public function imageUrl() : Attribute
    {
        if (str($this->getAttribute('image'))->contains('http'))
        {
            return new Attribute(
                get:  fn () => $this->getAttribute('image')
            );
        }

        return new Attribute(
            get:  fn () => $this->getAttribute('image')
                ? Storage::disk(config('filesystems.default'))->url($this->getAttribute('image'))
                : asset('assets/admin/app-assets/images/default/user.png')
        );
    }

    public function getInitialAttribute()
    {
        return str($this->name)->limit(1,'');
    }

    /**
     * @param $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
