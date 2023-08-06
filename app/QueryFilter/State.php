<?php

namespace App\QueryFilter;

use App\Models\UserRefill;
use App\Models\UserWithdrawal;

class State extends Filter
{

    protected function applyFilters($builder)
    {
        $q = request($this->filterName());

        if (empty($q) || !is_numeric($q)) {
            return $builder;
        }

        $model = $builder->getModel();

        if ($model instanceof UserWithdrawal ||
            $model instanceof UserRefill
        )
        {
            $builder->where('state', $q);
        }

        return $builder;
    }
}
