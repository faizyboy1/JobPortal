<?php

namespace App\Observers;

use App\Document;
use App\Helper\Files;

class DocumentObserver
{
    public function saving(Document $document)
    {
        if (company()) {
            $document->company_id = company()->id;
        }
    }

    public function updating(Document $document){
        $original = $document->getOriginal();

        if ($document->isDirty('hashname')){
            Files::deleteFile($original['hashname'], 'documents/'.$original['documentable_id']);
        }
    }
}
