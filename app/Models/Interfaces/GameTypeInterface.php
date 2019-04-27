<?php
namespace App\Models\Interfaces;

interface GameTypeInterface
{

    /**
     * 与机型的多对多关系.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types();
    
    /**
     * 保存机型
     * @param $types
     * @return mixed
     */
    public function saveTypes($types);

}