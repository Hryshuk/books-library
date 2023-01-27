<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/custombooks" )
 */
class CustomBooksController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/")
     */
    public function list(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->getCustomBookList();
        $booksORM = $bookRepository->getCustomBookListORM();

        return $this->render('customBooks/list.html.twig', [
            'books' => $books,
            'booksORM' => $booksORM,
        ]);
    }
}