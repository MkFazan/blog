<?php

namespace App;

use App\Models\Article;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The constantes roles users.
     *
     */
    const ADMIN = 1;
    const BLOGGER = 2;
    const READER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The array roles users.
     *
     * @var array
     */
    public static $userRoles = [
        self::BLOGGER => 'blogger',
        self::READER => 'reader',
    ];

    /**
     * The array all roles users.
     *
     * @var array
     */
    public static $allUserRoles = [
        self::ADMIN => 'admin',
        self::BLOGGER => 'blogger',
        self::READER => 'reader',
    ];

    /**
     * @return bool
     */
    public function isAdmin(){
        return ($this->role == User::ADMIN) ? true : false;
    }

    /**
     * @return bool
     */
    public function isBlogger(){
        return ($this->role == User::BLOGGER) ? true : false;
    }

    /**
     * @return bool
     */
    public function isReader(){
        return ($this->role == User::READER) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorite()
    {
        return $this->belongsToMany(Article::class, 'article_favorites');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class, 'author_id', 'id');
    }
}
