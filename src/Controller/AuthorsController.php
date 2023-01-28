<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/authors" )
 */
class AuthorsController extends AbstractController
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/")
     */
    public function list(): Response
    {
        $authors = $this->authorRepository->findAll();

        return $this->render('authors/list.html.twig', ['authors' => $authors]);
    }

    /**
     * @Route("/{id}", name="app_authors_view")
     */
    public function view($id): Response
    {
        $author = $this->authorRepository->find($id);

        return $this->render('authors/view.html.twig', ['author' => $author]);
    }

    /**
     * @Route("/edit/{id}", name="app_authors_edit")
     */
    public function edit($id): Response
    {
        $author = $this->authorRepository->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id '.$id);
        }

        return $this->render('authors/edit.html.twig', ['author' => $author]);
    }

    /**
     * @Route("/delete/{id}", name="app_authors_delete")
     */
    public function delete($id, EntityManagerInterface $em): Response
    {
        $author = $this->authorRepository->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id '.$id);
        }

        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('app_authors_list');
    }
}