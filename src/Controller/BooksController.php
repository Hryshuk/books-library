<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/books" )
 */
class BooksController extends AbstractController
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/",  name="app_books_list")
     */
    public function list(): Response
    {
        $books = $this->bookRepository->findAll();

        return $this->render('books/list.html.twig', ['books' => $books]);
    }

    /**
     * @Route("/{id}", name="app_books_view")
     */
    public function view($id): Response
    {
        $book = $this->bookRepository->find($id);

        return $this->render('books/view.html.twig', ['book' => $book]);
    }

    /**
     * @Route("/edit/{id}", name="app_books_edit")
     */
    public function edit($id): Response
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }

        return $this->render('books/edit.html.twig', ['book' => $book]);
    }

    /**
     * @Route("/delete/{id}", name="app_books_delete")
     */
    public function delete($id, EntityManagerInterface $em): Response
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }

        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('app_books_list');
    }
}