<?php

namespace App\EventListener;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

class BookNumberSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [Events::onFlush, Events::postFlush];
    }

// The variant using UnitOfWork
    public function onFlush(OnFlushEventArgs $event)
    {
        $em = $event->getObjectManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Book) {
                $authors = $entity->getAuthors();
                if ($authors instanceof PersistentCollection) {
                    /*
                    foreach ($authors->getInsertDiff() as $author) {
                        if ($author instanceof Author) {
                            $books = $author->getBooks();
                            $author->setBooksNumber($books->count() + 1);
                            $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($author)), $author);
                        }
                    }
                    foreach ($authors->getDeleteDiff() as $author) {
                        if ($author instanceof Author) {
                            $books = $author->getBooks();
                            $author->setBooksNumber($books->count() - 1);
                            $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($author)), $author);
                        }
                    }
                    */
                    $needUpdateAuthors = array_merge($authors->getInsertDiff(), $authors->getDeleteDiff());
                    foreach ($needUpdateAuthors as $author) {
                        if ($author instanceof Author) {
                            $author->setIsUpdated(false);
                            $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($author)), $author);
                        }
                    }
                }
            }
        }

        /*
        foreach ($uow->getScheduledCollectionDeletions() as $col) {
            if ($col instanceof PersistentCollection) {
                $mapping = $col->getMapping();
                if (($mapping["sourceEntity"] == Book::class && $mapping["targetEntity"] == Author::class)) {
                    $repository = $em->getRepository(Author::class);
                    $count = $repository->setNeedUpdateBooksNumber();
                }
            }
        }
        */
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        $repository = $event->getObjectManager()->getRepository(Author::class);
        $count = $repository->recalculateBooksNumber();
    }

}
