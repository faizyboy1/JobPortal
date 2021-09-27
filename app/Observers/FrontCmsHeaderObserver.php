<?php

namespace App\Observers;

use App\FrontCmsHeader;
use App\Helper\Files;

class FrontCmsHeaderObserver
{
    public function updating(FrontCmsHeader $cms)
    {
        $original = $cms->getOriginal();

        if ($cms->isDirty('header_image')) {
            Files::deleteFile($original['header_image'], 'header-image');
        }

        if ($cms->isDirty('header_backround_image')) {
            Files::deleteFile($original['header_backround_image'], 'header-background-image');
        }

        if ($cms->isDirty('logo')) {
            Files::deleteFile($original['logo'], 'front-logo');
        }
    }
}
