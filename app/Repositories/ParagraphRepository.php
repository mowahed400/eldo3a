<?php

namespace App\Repositories;

use App\Models\Paragraph;
use Illuminate\Database\Eloquent\Model;

class ParagraphRepository extends BaseRepositories implements \App\Contracts\ParagraphContract
{
    public function __construct(Paragraph $model, array $filters = [])
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
        $p = $id instanceof $this->model ? $id : $this->findOneById($id);
        $p->update($data);
        return $p->refresh();
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        return ($id instanceof $this->model ? $id : $this->findOneById($id))->delete();
    }
}
