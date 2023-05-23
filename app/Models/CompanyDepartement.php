<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDepartement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function _get($id = null)
    {
        if ($id == null) {
            return self::orderByDesc('id')->get();
        } else {
            return self::where('id', $id)->first();
        }
    }

    public static function _save($data, $id = null)
    {
        if ($id == null) {
            $model = new self;
        } else {
            $model = self::find($id);
            $model->user_id = Auth::id();
        }

        $model->fill($data);
        $model->save();

        return $model->id;
    }

    public static function getByCompany($company_id, $current_id = null)
    {
        $departements = self::whereHas('site', function ($query) use ($company_id) {
            return $query->where('company_id', $company_id);
        });

        if ($current_id != null) {
            $departements = $departements->where('id', '!=', $current_id);
        }

        $departements = $departements->with('site')->get();
        return $departements;
    }

    public static function _delete($id)
    {
        self::where('id', $id)->delete();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the site that owns the CompanyDepartement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(CompanySite::class, 'company_site_id');
    }
}
