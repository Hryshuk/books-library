<?php

namespace App\Controller;

use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api" )
 */
class ApiController extends AbstractController
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/books/{id}", name="api_books_edit", requirements={"id"="\d+"}, methods={"PUT"})
     */
    public function edit($id, Request $request): Response
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }

        $form = $this->createForm(BookType::class, $book, ['csrf_protection' => false]);
        $data = json_decode($request->getContent(), true);
        $form->submit($data, false);
        if ($form->isValid()) {
            $this->bookRepository->add($book);
            return new JsonResponse(['status' => 200, 'data' => $book], 200);
        }

        return new JsonResponse(['status' => 422, 'errors' => $this->getErrorsFromForm($form)], 422);
    }

    private function getErrorsFromForm(FormInterface $form, bool $child = false): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            if ($child) {
                $errors[] = $error->getMessage();
            } else {
                $errors[$error->getOrigin()->getName()][] = $error->getMessage();
            }
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm, true)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }

}