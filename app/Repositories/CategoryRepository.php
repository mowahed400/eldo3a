<?php

namespace App\Repositories;

use App\Models\Category;
use App\Traits\UploadAble;
use JetBrains\PhpStorm\Pure;

class CategoryRepository extends BaseRepositories implements \App\Contracts\CategoryContract
{
    use UploadAble;

    #[Pure]
    public function __construct(Category $model, array $filters = [
        \App\QueryFilter\Search::class,
        \App\QueryFilter\Section::class,
        \App\QueryFilter\ParentCategory::class,
    ])
    {
        parent::__construct($model, $filters);
    }

    /**
     * @inheritDoc
     */
    public function new(array $data)
    {
        if (array_key_exists('image',$data))
        {
            $data['image'] = $this->uploadOne($data['image'],'category/img');
        }

        return $this->model::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $category = $this->findOneById($id);

        if (array_key_exists('image',$data))
        {
            if ($category->image)
            {
                $this->deleteOne($category->image);
            }

            $data['image'] = $this->uploadOne($data['image'],'category/img');
        }

        $category->update($data);

        return $category->refresh();
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        $category = $this->findOneById($id);

        if ($category->image)
        {
            $this->deleteOne($category->image);
        }

        return $category->delete();
    }
}
