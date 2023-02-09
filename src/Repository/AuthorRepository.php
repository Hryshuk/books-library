<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Author $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Author $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function setNeedUpdateBooksNumber()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE author SET `is_updated`= 0';
        $count = $conn->executeStatement($sql);

        return $count;
    }

    public function recalculateBooksNumberForAll()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            UPDATE author AS a
            SET
            `books_number` = (
                SELECT COUNT(ba.book_id)
                FROM book_author AS ba
                WHERE ba.author_id = a.id
            ),
            `is_updated` = 1
            WHERE 1
            ';
        $count = $conn->executeStatement($sql);

        return $count;
    }

    public function recalculateBooksNumber()
    {
        $conn = $this->getEntityManager()->getConnection();
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

        return $count;
    }


    // /**
    //  * @return Author[] Returns an array of Author objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
