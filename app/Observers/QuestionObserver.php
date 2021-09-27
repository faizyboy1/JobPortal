<?php

namespace App\Observers;

use App\Question;

class QuestionObserver
{
    public function saving(Question $question)
    {
        if (company()) {
            $question->company_id = company()->id;
        }
    }
}
