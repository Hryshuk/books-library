<?php

namespace App\EventListener;

use Doctrine\ORM\Event\PostFlushEventArgs;

class BookNumberListener
{
    public function postFlush(PostFlushEventArgs $event)
    {
        $conn = $event->getObjectManager()->getConnection();
        $sql = '
        UPDATE author AS a
        SET `books_number`=(
            SELECT COUNT(ba.book_id)
            FROM book_author AS ba
            WHERE ba.author_id = a.id
        )
        ';
        $count = $conn->executeStatement($sql);
    }
}
