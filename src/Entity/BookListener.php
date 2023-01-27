<?php

namespace App\Entity;

use App\Entity\Book;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class BookListener
{
    public function preUpdate(Book $book, PreUpdateEventArgs $event)
    {
//       if ($event->hasChangedField('authors')) {
//           var_dump(count($event->getOldValue('authors')));
//           var_dump(count($event->getNewValue('authors')));
//       }
//       var_dump ($event->getEntityChangeSet());
//       exit;

    }
}
