<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Filters\ItemFilter;

class Item extends Model
{
    protected $guarded = [];

    public static function rules() {
        return [
            'name' => 'required',
        ];
    }

    public function scopeFilter($builder, ItemFilter $filter)
    {
        return $filter->apply($builder);
    }
}
