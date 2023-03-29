<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Entity\Quack;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quack/crud')]
class QuackCrudController extends AbstractController
{
    #[Route('/', name: 'app_quack_crud_index', methods: ['GET'])]
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack_crud/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quack_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuackRepository $quackRepository): Response
    {
//        dd($request->query->get('iscomment'));
        $quack = new Quack();
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        $duck = $this->getUser();
        $this->denyAccessUnlessGranted('view', $duck);

        if ($form->isSubmitted() && $form->isValid()) {
            $quack->setAuthor($this->getUser()->getDuckname());
            $quack->setDuckId($this->getUser());
            if ($request->query->get('iscomment')) {
                $quack->setIsComment(true);
                $quack->setIdLinkedPost($request->query->get('quackid'));
            } else {
                $quack->setIsComment(false);
            }
            $quackRepository->save($quack, true);

            return $this->redirectToRoute('app_quack_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quack_crud/new.html.twig', [
            'quack' => $quack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quack_crud_show', methods: ['GET'])]
    public function show(Quack $quack): Response
    {
        return $this->render('quack_crud/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quack_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quack $quack, QuackRepository $quackRepository): Response
    {
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

//        dd($quack);
//        $duck = $this->getUser();
        $this->denyAccessUnlessGranted('edit', $quack);

        if ($form->isSubmitted() && $form->isValid()) {
            $quackRepository->save($quack, true);

            return $this->redirectToRoute('app_quack_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quack_crud/edit.html.twig', [
            'quack' => $quack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quack_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Quack $quack, QuackRepository $quackRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quack->getId(), $request->request->get('_token'))) {
            $quackRepository->remove($quack, true);
        }
        return $this->redirectToRoute('app_quack_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
