<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

use App\Http\Filters\ItemFilter;

class Item extends Model
{
    protected $guarded = [];

    public static function rules() {
        $id = request()->route('item');

        return [
            //'name' => 'required',
            'name' => [
                'required',
                Rule::unique('items')->ignore($id ? $id : null),
            ],
        ];
    }

    public function scopeFilter($builder, ItemFilter $filter)
    {
        return $filter->apply($builder);
    }
}
