<?php

namespace App\Observers;

use App\OnboardFiles;

class OnBoardFilesObserver
{
    public function saving(OnboardFiles $onBoardFiles)
    {
        if (company()) {
            $onBoardFiles->company_id = company()->id;
        }
    }
}
