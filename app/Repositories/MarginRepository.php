<?php

namespace App\Repositories;

use App\Models\Margin;

class MarginRepository extends BaseRepositories implements \App\Contracts\MarginContract
{

    public function __construct(Margin $model, array $filters = [

    ])
    {
        parent::__construct($model, $filters);
    }

    /**
     * @inheritDoc
     */
    public function new(array $data)
    {
        return $this->model::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $margin = $this->findOneById($id);
        $margin->update($data);
        return $margin->refresh();
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        return $this->findOneById($id)->delete();
    }
}
