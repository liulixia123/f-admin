<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Config;

trait GameTypeTrait
{

    /**
     * 与机型的多对多关系.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany(Config::get('admin.type'), Config::get('admin.game_type_table'),
            Config::get('admin.game_foreign_key'), Config::get('admin.type_foreign_key'));
    }

    /**
     * 保存机型
     * @param $types
     * @return mixed
     */
    public function saveTypes($types)
    {
        if (!empty($types)) {
            $this->types()->sync($types);//任何不在给定数组中的 IDs 将会从中介表中被删除。
        } else {
            $this->types()->detach();//移除所有
        }
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function($game) {
            if (!method_exists(Config::get('admin.game'), 'bootSoftDeletes')) {
                $game->types()->sync([]);                
            }
            return true;
        });
    }

}