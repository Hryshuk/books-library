<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/{id}", name="app_authors_view", requirements={"id"="\d+"})
     */
    public function view($id): Response
    {
        $author = $this->authorRepository->find($id);

        return $this->render('authors/view.html.twig', ['author' => $author]);
    }

    /**
     * @Route("/new", name="app_authors_new")
     */
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorRepository->add($author);

            return $this->redirectToRoute('app_authors_list');
        }

        return $this->render('authors/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_authors_edit", requirements={"id"="\d+"})
     */
    public function edit($id, Request $request): Response
    {
        $author = $this->authorRepository->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id '.$id);
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorRepository->add($author);

            return $this->redirectToRoute('app_authors_list');
        }

        return $this->render('authors/edit.html.twig', ['author' => $author, 'form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="app_authors_delete", requirements={"id"="\d+"})
     */
    public function delete($id, EntityManagerInterface $em): Response
    {
        $author = $this->authorRepository->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id '.$id);
        }

        $this->authorRepository->remove($author);

        return $this->redirectToRoute('app_authors_list');
    }
}