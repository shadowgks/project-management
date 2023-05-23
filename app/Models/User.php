<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Auth;
use DB;
use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use SpatieLogsActivity;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'api_token',
        'password',
        'is_admin',
        'image_name',
        'role_id',
        'last_seen',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get a fullname combination of first_name and last_name
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Prepare proper error handling for url attribute
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->info) {
            return asset($this->info->avatar_url);
        }

        return asset(theme()->getMediaUrlPath() . 'avatars/blank.png');
    }

    public static function updatePassword($password)
    {
        $this_user = self::find(Auth::id());
        $this_user->password = Hash::make($password);
        $this_user->save();
    }

    public static function changeLangOfUser($lang, $user_id = null)
    {
        if (in_array($lang, config('app.available_locales'))) {
            $user = self::find(($user_id == null ? Auth::id() : $user_id));
            $user->lang = $lang;
            $user->save();
        } else {
            throw new \Exception($lang . ' is not allowed!');
        }
    }

    public static function changeLang($lang)
    {
        self::changeLangOfUser($lang);
        app()->setLocale($lang);
        session()->put('locale', $lang);
    }

    public static function getOnlineUsers()
    {
        return self::whereNotNull('last_seen')->where('id', '!=', Auth::id())->orderBy('last_seen', 'DESC')->get();
    }

    public static function getUsers($offset = null)
    {
        if ($offset == null && $offset != 0) {
            return self::where('id', '!=', Auth::id())->orderBy('first_name', 'DESC')->get();
        } else {
            return [
                'count' => self::where('id', '!=', Auth::id())->count(),
                'list' => self::where('id', '!=', Auth::id())->orderBy('first_name', 'DESC')->offset($offset)->limit(12)->get(),
            ];
        }
    }

    public static function checkUserExists($id)
    {
        return self::where('id', $id)->count() > 0;
    }

    public static function getUsersByPage($page)
    {
        $page = (int) $page - 1;
        return self::getUsers(($page * 12));
    }

    public static function _get($id = null)
    {
        if ($id == null) {
            return self::select(DB::raw('*, CONCAT(first_name, " ", last_name) as full_name'))->orderBy('first_name')->get();
        } else {
            return self::select(DB::raw('*, CONCAT(first_name, " ", last_name) as full_name'))->where('id', $id)->first();
        }
    }

    /**
     * User relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }
}
