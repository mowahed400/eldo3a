<?php

namespace App\Repositories;

use App\Models\ContentMargin;
use Illuminate\Database\Eloquent\Model;

class ContentMarginRepository extends BaseRepositories implements \App\Contracts\ContentMarginContract
{
    public function __construct(ContentMargin $model, array $filters = [])
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
        $content_margin = $this->findOneById($id);
        $content_margin->update($data);
        return $content_margin->refresh();
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        return $this->findOneById($id)->delete();
    }
}
