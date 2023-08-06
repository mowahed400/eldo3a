<?php

namespace App\QueryFilter;

use App\Models\Category;

class Section extends Filter
{

    protected function applyFilters($builder)
    {
        $q = request($this->filterName());

        if (empty($q) || !is_numeric($q)) {
            return $builder;
        }

        $model = $builder->getModel();

        if ($model instanceof Category
        )
        {
            $builder->where('section_id', $q);
        }

        return $builder;
    }
}
