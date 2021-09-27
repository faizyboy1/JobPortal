<?php

namespace App\Observers;

use App\Skill;

class SkillObserver
{
    public function saving(Skill $skill)
    {
        if (company()) {
            $skill->company_id = company()->id;
        }
    }
}
