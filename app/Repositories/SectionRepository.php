<?php

namespace App\Repositories;

use App\Models\Section;
use App\Traits\UploadAble;
use JetBrains\PhpStorm\Pure;

class SectionRepository extends BaseRepositories implements \App\Contracts\SectionContract
{
    use UploadAble;

    #[Pure]
    public function __construct(Section $model, array $filters = [
        \App\QueryFilter\Search::class
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
            $data['image'] = $this->uploadOne($data['image'],'section/img');
        }


        if( $this->model::where('name','like','%' . $data['name']['ar'] . '%')->orWhere('name','like','%' . $data['name']['en'] . '%')->count() == null){
            return $this->model::create($data);
        }

        return false;

    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $section = $this->findOneById($id);

        if (array_key_exists('image',$data))
        {
            if ($section->image)
            {
                $this->deleteOne($section->image);
            }

            $data['image'] = $this->uploadOne($data['image'],'section/img');
        }

        $section->update($data);

        return $section->refresh();
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        $section = $this->findOneById($id);

        if ($section->image)
        {
            $this->deleteOne($section->image);
        }

        return $section->delete();
    }
}
