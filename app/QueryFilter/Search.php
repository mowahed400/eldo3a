<?php

namespace App\QueryFilter;

use App\Models\Category;
use App\Models\Section;
use App\Models\SharedBackgrounds;
use App\Models\User;
use App\Models\Admin;
use App\Models\content;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Search extends Filter
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

        if ($model instanceof Admin ) {
            $builder->where('name', 'like', '%' . $q . '%')
                ->orWhere('email', 'like', '%' . $q . '%');
        }

        if ($model instanceof Role) {
            $builder->where('name', 'like', '%' . $q . '%');
        }

        if ($model instanceof AdminNotification ) {
            $builder->where('title', 'like', '%' . $q . '%')
                ->orWhere('message', 'like', '%' . $q . '%');
        }

        if ($model instanceof User) {
            $builder->where('name', 'like', '%' . $q . '%')
                ->orWhere('phone', 'like', '%' . $q . '%');
        }

        if ($model instanceof Section || $model instanceof Category) {
            $builder->where('name->en', 'like', '%' . $q . '%')
                    ->orWhere('name->ar', 'like', '%' . $q . '%')
                    ->orWhere('description->ar', 'like', '%' . $q . '%')
                ->orWhere('description->en', 'like', '%' . $q . '%');
        }

        return $builder;
    }
}
