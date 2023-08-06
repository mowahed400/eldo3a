<?php

namespace App\QueryFilter;

use App\Models\Category;

class ParentCategory extends Filter
{

    protected function applyFilters($builder)
    {
        $q = request($this->filterName());

        if ( !is_numeric($q)) {
            return $builder;
        }

        $model = $builder->getModel();

        if ((int)$q === 0)
        {
            return $builder->whereNull('parent_id');
        }


        if ($model instanceof Category)
        {
            return$builder->where('parent_id', $q);
        }

        return $builder;
    }
}
