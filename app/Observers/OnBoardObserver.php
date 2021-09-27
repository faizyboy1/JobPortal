<?php

namespace App\Observers;

use App\Onboard;

class OnBoardObserver
{
    public function saving(Onboard $onBoard)
    {
        if (company()) {
            $onBoard->company_id = company()->id;
        }
    }
}
