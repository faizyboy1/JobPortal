<?php

namespace App\Observers;

use App\Helper\Files;
use App\TodoItem;

class TodoItemObserver
{
    public function saving(TodoItem $todoItem)
    {
        if (company()) {
            $todoItem->company_id = company()->id;
        }
    }
}
