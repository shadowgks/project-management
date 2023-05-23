<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'properties' => 'array',
    ];

    public static function _get($id = null)
    {
        if ($id == null) {
            // $uploads = new self;
            return self::get();
        } else {
            return self::where('id', $id)->first();
        }
    }

    public static function _get_by_module($app_module_id)
    {
        // return self::where('app_module_id', $app_module_id)->orderByDesc('id')->get();
        return self::get();
    }

    public static function _save($data, $id = null)
    {
        if ($id == null)
            $upload = new self;
        else
            $upload = self::find($id);

        $upload->fill($data);
        $upload->user_id = Auth::id();
        $upload->save();

        return $upload->id;
    }

    public static function _delete($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function _delete_by_module($module_id)
    {
        self::where('app_module_id', $module_id)->delete();
    }

    /**
     * Get the user associated with the Upload
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
