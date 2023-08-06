<?php

namespace App\QueryFilter;

use App\Models\Service;


class OrderByRate extends Filter
{

    protected function applyFilters($builder)
    {
        $q = request($this->filterName());

        if (!in_array($q, ['asc', 'desc'])) {
            return $builder;
        }

        $model = $builder->getModel();

        if ($model instanceof Service) {

            $builder->join('users', 'user_id', 'users.id')->select('services.*', 'users.rate as rate')->orderBy('rate', $q);

        }

        return $builder;
    }
}
