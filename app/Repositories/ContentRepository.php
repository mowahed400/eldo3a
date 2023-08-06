<?php

namespace App\Repositories;

use App\Models\Content;
use App\Traits\UploadAble;

class ContentRepository extends BaseRepositories implements \App\Contracts\ContentContract
{
    use UploadAble;

    public function __construct(Content $model, array $filters = [])
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
        $content = $this->findOneById($id);
        $content->update($data);
        return $content->refresh();
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        $content = $this->findOneById($id);

        if ($content->voice_en)
        {
            $this->deleteOne($content->voice_en);
        }

        if ($content->voice_ar)
        {
            $this->deleteOne($content->voice_ar);
        }

        return $content->delete();
    }

    public function uploadVoice($content, array $data)
    {
        $content = $content instanceof  $this->model ? $content : $this->findOneById($content);

        if (array_key_exists($data['type'],$content->voice ?? []))
        {
            $this->deleteOne($content->voice[$data['type']]);
        }
        $voice = $content->voice;
        $path = $this->uploadOne($data['voice'],'contents/'.$content->id.'/'.$data['type'].'/');

        $voice[$data['type']] = $path;

        $content->update([
            'voice' => $voice
        ]);

        return $content->refresh();
    }

    public function removeVoice($content, string $type)
    {
        $content = $content instanceof  $this->model ? $content : $this->findOneById($content);
        if (array_key_exists($type,$content->voice ?? []))
        {
            $this->deleteOne($content->voice[$type]);
        }
        $voice = $content->voice;
        unset($voice[$type]);
        $content->update([
            'voice'  => $voice,
        ]);
        return $content->refresh();
    }
}
