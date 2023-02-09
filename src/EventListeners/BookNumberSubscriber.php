<?php

namespace App\EventListener;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

class BookNumberSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [Events::preUpdate, Events::postFlush, Events::onFlush];
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();
/*
        // The first variant without using UnitOfWork
        // Also working code
        if ($entity instanceof Book) {
            $authors = $entity->getAuthors();
            if ($authors instanceof PersistentCollection) {
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
        }
*/
        if ($entity instanceof Author) {
            $books = $entity->getBooks();
            $entity->setBooksNumber($books->count());
        }
}


// The second variant using UnitOfWork
    public function onFlush(OnFlushEventArgs $event)
    {
        $em = $event->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Book) {
                $authors = $entity->getAuthors();
                if ($authors instanceof PersistentCollection) {
                    $allAuthors = [];
                    foreach (array_merge($authors->getSnapshot(), $authors->toArray()) as $author) {
                        if ($author instanceof Author) {
                            $allAuthors[$author->getId()] = $author;
                        }
                    }
                    $oldAuthorIds = array_map(fn(Author $author): int => $author->getId(), $authors->getSnapshot());
                    $newAuthorIds = array_map(fn(Author $author): int => $author->getId(), $authors->toArray());
                    $diffIds = array_merge(array_diff($oldAuthorIds, $newAuthorIds), array_diff($newAuthorIds, $oldAuthorIds));

                    foreach ($diffIds as $id) {
                        $author = $allAuthors[$id];
                        if ($author instanceof Author) {
                            $author->setIsUpdated(false);
                            $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($author)), $author);
                        }
                    }
                }
            }
        }

        foreach ($uow->getScheduledCollectionDeletions() as $col) {
            if ($col instanceof PersistentCollection) {
                $mapping = $col->getMapping();
                if (($mapping["sourceEntity"] == Book::class && $mapping["targetEntity"] == Author::class)) {
                    $repository = $em->getRepository(Author::class);
                    $count = $repository->setNeedUpdateBooksNumber();
                }
            }
        }
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        $repository = $event->getObjectManager()->getRepository(Author::class);
        $count = $repository->recalculateBooksNumber();
    }

}
