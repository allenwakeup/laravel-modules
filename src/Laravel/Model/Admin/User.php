<?php


/**
 *
 * This file <User.php> was created by <PhpStorm> at <2021/2/4>,
 * and it is part of project <laravel-modules>.
 * @author  Allen Li <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Model\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[] $fillable
     */
    protected $fillable = [
      'name',
      'email',
      'password',
      'phone',
      'country_code',
      'path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[] $hidden
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[] $catts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isOwnerOf($model)
    {
        return $this->id === $model->user_id;
    }

}