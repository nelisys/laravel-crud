<?php

namespace App\Http\Filters;

class ItemFilter extends Filter
{
    protected $filters = [
        'name',
        'q',
        'sort',
    ];

    protected function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%{$name}%");
    }

    protected function q($q)
    {
        return $this->builder->where(function ($query) use ($q) {
            $query->where('name', 'LIKE', "%{$q}%");
        });
    }

    protected function sort($sort)
    {
        return $this->builder->orderBy($sort, request('order', 'asc'));
    }
}
