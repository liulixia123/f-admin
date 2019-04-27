<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\GameTypeInterface;
use App\Models\Traits\GameTypeTrait;
class Game extends Model implements GameTypeInterface
{
	use GameTypeTrait;
    protected $table = 'games';
    public function typeToIds()
    {
        $types =$this->types;
        $ids = [];
        if (count($types) > 0) {
            foreach ($types as $type) {
                if (is_object($type)) {
                    $ids[] = $type->id;
                } else if (is_array($type) && isset ($type['id'])) {
                    $ids[] = $type['id'];
                }
            }
        }
        return $ids;
    }
}
