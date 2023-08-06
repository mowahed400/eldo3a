<?php

namespace App\Contracts;

use App\Contracts\Base\CrudContract;

interface ContentContract extends CrudContract
{
    public function uploadVoice($content,array $data);
    public function removeVoice($content,string $type);
}
