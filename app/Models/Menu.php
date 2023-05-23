<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $guarded = [];

    public static function getSources()
    {
        return self::where('category', 'dropdown')->get();
    }

    public static function getOrders($item = null)
    {
        $arrayHelper = [];

        if ($item == null)
            $countItems = self::all()->count() + 1;
        else {
            $items = self::where('id', $item)->with('subs')->first();
            $countItems = count($items == null ? [] : $items->subs);
        }

        for ($i = 1; $i <= $countItems; $i++) {
            array_push($arrayHelper, $i);
        }

        return $arrayHelper;
    }

    public static function _get($id = null, $withGet = true)
    {
        if ($id == null)
            return ($withGet ? self::whereNot('category', 'sub_element')->with('subs')->orderBy('name')->get() : self::whereNot('category', 'sub_element')->with('subs')->orderBy('name'));
        else
            return self::where('id', $id)->with('subs')->first();
    }

    public static function getSubs($source)
    {
        return self::where('source', $source)->orderBy('name')->get();
    }

    public static function _save($data, $id = null)
    {
        $new_data = $data;
        unset($new_data['sub_elements']);

        $menu = ($id == null ? new self : self::find($id));
        if ($new_data['category'] == 'dropdown') {
            unset($new_data['path']);
            unset($new_data['source']);
        }
        $menu->fill($new_data);
        if ($id == null) {
            $menu->user_id = Auth::id();
        }
        $menu->save();

        if ($data['category'] == 'dropdown') {
            $saved_menus = [];

            foreach ($data['sub_elements'] as $element) {
                $new_element = $element;
                unset($new_element['id']);
                $sub_menu = ($element['id'] == '' ? new self : self::find($element['id']));
                $sub_menu->fill($new_element);
                if ($element['id'] == '') {
                    $sub_menu->source = $menu->id;
                    $sub_menu->user_id = Auth::id();
                }
                $sub_menu->save();

                array_push($saved_menus, $sub_menu->id);
            }

            if ($id != null) {
                $all_menus = self::getSubs($id);

                foreach ($all_menus as $mn) {
                    if (!in_array($mn->id, $saved_menus)) {
                        $mn->delete();
                    }
                }
            }
        }

        return [
            'success' => true,
        ];
    }

    public static function _delete($id)
    {
        $menu = self::find($id);

        if ($menu->category == 'dropdown')
            return self::where('source', $id)->delete() && $menu->delete();
        else
            return $menu->delete();
    }

    public static function getLastOrder($source = null)
    {
        if ($source == null) {
            $item = self::select('item_order')->orderByDesc('item_order')->first();
            return ($item == null ? 1 : $item->item_order);
        } else {
            $item = self::select('item_order')->where('source', $source)->orderByDesc('item_order')->first();
            return ($item == null ? 1 : $item->item_order);
        }
    }

    public static function _delete_by_module($module_name)
    {
        self::where('name', $module_name)->delete();
    }

    /**
     * Get all of the subs for the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subs()
    {
        return $this->hasMany(self::class, 'source', 'id');
    }

    /**
     * Get the parent associated with the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'source');
    }
}
