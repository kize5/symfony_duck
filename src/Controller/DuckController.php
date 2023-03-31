<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Form\DuckType;
use App\Repository\DuckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Route('/duck')]
class DuckController extends AbstractController
{
    private HttpClientInterface $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/index', name: 'app_duck_index', methods: ['GET'])]
    public function index(DuckRepository $duckRepository): Response
    {
//        dd($duckRepository->findAll());
        return $this->render('duck/index.html.twig', [
            'ducks' => $duckRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_duck_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DuckRepository $duckRepository): Response
    {
        $duck = new Duck();
        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $duckRepository->save($duck, true);

            return $this->redirectToRoute('app_duck_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('duck/new.html.twig', [
            'duck' => $duck,
            'form' => $form,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/{id}', name: 'app_duck_show', methods: ['GET'])]
    public function show(Duck $duck): Response
    {
//        ------- Example de call api ---------
//        $response = $this->client->request(
//            'GET',
//            'https://random-d.uk/api/v2/random'
//        );
//        $content = $response->toArray();

        $this->denyAccessUnlessGranted('view', $duck);

        return $this->render('duck/show.html.twig', [
            'duck' => $duck,
//            'content' => $content,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_duck_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Duck $duck, DuckRepository $duckRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);
//        dd($duck);
        $this->denyAccessUnlessGranted('edit', $duck);

        if ($form->isSubmitted() && $form->isValid()) {
            $duck->setPassword(
                $userPasswordHasher->hashPassword($duck, $form->get('password')->getData())
            );
            $duckRepository->save($duck, true);

            return $this->redirectToRoute('app_duck_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('duck/edit.html.twig', [
            'duck' => $duck,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_duck_delete', methods: ['POST'])]
    public function delete(Request $request, Duck $duck, DuckRepository $duckRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duck->getId(), $request->request->get('_token'))) {
            $duckRepository->remove($duck, true);
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
