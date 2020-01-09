<?php

namespace App\Http\Filters;

class ItemFilter extends Filter
{
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
}
