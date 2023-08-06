<?php

namespace App\QueryFilter;

use App\Models\Admin;
use App\Models\City;
use App\Models\Nationality;


class Role extends Filter
{

    protected function applyFilters($builder)
    {
        $q = request($this->filterName());

        if (empty($q)) {
            return $builder;
        }
        $model = $builder->getModel();

        if (is_array($q)) {
            return $builder;
        }

        if ($model instanceof Admin) {
            $builder->whereHas('roles', function($query) use ($q)
        {
            $query->where('id', $q);
        });
        }


        return $builder;
    }
}
