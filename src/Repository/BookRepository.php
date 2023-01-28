<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Book $entity, bool $flush = true): void
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
    public function remove(Book $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getCustomBookList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
SELECT b.name, COUNT(b.id) AS authorsNumber  FROM `book` AS b
JOIN book_author AS ba ON b.id=ba.book_id
GROUP BY b.id
HAVING authorsNumber > 1
            ';
        $resultSet = $conn->executeQuery($sql);

        return $resultSet->fetchAllKeyValue();
    }

    public function getCustomBookListORM()
    {
        $data = $this->createQueryBuilder('b')
            ->select('b.name')
            ->addSelect('COUNT(authors) as authorsNumber')
            ->innerJoin('b.authors', 'authors')
            ->groupBy('b.id')
            ->having('authorsNumber > 1')
            ->getQuery()
            ->getScalarResult();

        return array_reduce($data, function ($res, $item) {
            $res[$item['name']] = $item['authorsNumber'];
            return $res;
        }, []);
    }

}
