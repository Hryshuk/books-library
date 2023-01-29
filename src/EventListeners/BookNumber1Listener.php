<?php

namespace App\EventListener;

use Doctrine\ORM\Event\PostFlushEventArgs;

class BookNumber1Listener
{
    public function postFlush(PostFlushEventArgs $event)
    {
        $conn = $event->getObjectManager()->getConnection();
        $sql = '
        UPDATE author AS a
        SET 
        `books_number` = (
            SELECT COUNT(ba.book_id)
            FROM book_author AS ba
            WHERE ba.author_id = a.id
        ), 
        `is_updated` = 1
        WHERE a.is_updated = 0
        ';
        $count = $conn->executeStatement($sql);
    }

}
