<?php

namespace App\EventListener;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class BookNumberListener
{
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();

        if ($entity instanceof Book) {
            $authors = $entity->getAuthors();
            $oldAuthorIds = array_map(fn(Author $author): int => $author->getId(), $authors->getSnapshot());
            $newAuthorIds = array_map(fn(Author $author): int => $author->getId(), $authors->toArray());
            $diffIds = array_merge(array_diff($oldAuthorIds, $newAuthorIds), array_diff($newAuthorIds, $oldAuthorIds));

            if (count($diffIds)) {
                $conn = $event->getObjectManager()->getConnection();
                $sql = 'UPDATE author AS a SET `is_updated`= 0 WHERE a.id IN (?)';
                $count = $conn->executeStatement($sql, [$diffIds], [\Doctrine\DBAL\Connection::PARAM_INT_ARRAY]);
                //var_dump($count);
            }
        }

        if ($entity instanceof Author) {
            $books = $entity->getBooks();
            $entity->setBooksNumber($books->count());
        }
    }

}
