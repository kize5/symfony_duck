<?php
//
namespace App\Controller;
//
//
use App\Repository\DuckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
//
class ApiController extends AbstractController
{
    #[Route('/test/api/duck', name: 'app_api_test')]
    public function index(DuckRepository $duckRepository, SerializerInterface $serializer): Response
    {
        $ducks = $duckRepository->findAll();
//        dd($ducks);
        $cleanjson = $serializer->serialize($ducks, 'json', ['groups' => ['duck']]);
        return new JsonResponse($cleanjson, json: true);
    }

}
