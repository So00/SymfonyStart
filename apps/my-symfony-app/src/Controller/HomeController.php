<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PropertyRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PropertyRepository $repository)
    {
        $properties = $repository->findLatestUnsold();
        return $this->render('home/index.html.twig', [
            "properties" => $properties
        ]);
    }
}
