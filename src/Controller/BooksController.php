<?php

namespace App\Controller;

use App\DTO\BookFilterDTO;
use App\Entity\Book;
use App\Form\BookFilterType;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(Request $request): Response
    {
        $bookFilter = new BookFilterDTO();
        $formFilter = $this->createForm(BookFilterType::class, $bookFilter);
        $formFilter->handleRequest($request);
        $books = $this->bookRepository->findAllByFilter($bookFilter->toArray());

        return $this->render('books/list.html.twig', ['books' => $books, 'form' => $formFilter->createView()]);
    }

    /**
     * @Route("/{id}", name="app_books_view", requirements={"id"="\d+"})
     */
    public function view($id): Response
    {
        $book = $this->bookRepository->find($id);

        return $this->render('books/view.html.twig', ['book' => $book]);
    }

    /**
     * @Route("/new", name="app_books_new")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('bookCover')->getData();
            if ($imageFile) {
                try {
                    $imageFileName = $fileUploader->upload($imageFile);
                    $book->setBookCover($imageFileName);
                } catch (UploadException $e) {
                    $form->addError(new FormError("File has not been uploaded. " . $e->getMessage()));
                    return $this->render('books/new.html.twig', ['form' => $form->createView()]);
                }
            }
            $this->bookRepository->add($book);

            return $this->redirectToRoute('app_books_list');
        }

        return $this->render('books/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_books_edit", requirements={"id"="\d+"})
     */
    public function edit($id, Request $request, FileUploader $fileUploader): Response
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('bookCover')->getData();
            if ($imageFile) {
                try {
                    $imageFileName = $fileUploader->upload($imageFile);
                    $book->setBookCover($imageFileName);
                } catch (UploadException $e) {
                    $form->addError(new FormError("File has not been uploaded. " . $e->getMessage()));
                    return $this->render('books/edit.html.twig', ['book' => $book, 'form' => $form->createView()]);
                }
            }
            $this->bookRepository->add($book);

            return $this->redirectToRoute('app_books_list');
        }

        return $this->render('books/edit.html.twig', ['book' => $book, 'form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="app_books_delete", requirements={"id"="\d+"})
     */
    public function delete($id, EntityManagerInterface $em): Response
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }

        $this->bookRepository->remove($book);

        return $this->redirectToRoute('app_books_list');
    }
}