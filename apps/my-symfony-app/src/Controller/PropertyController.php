<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;
    
    /**
     * @var ObjectManager
     */
    private $em;

    function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/property", name="property.index")
     */
    public function index()
    {
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => "property"
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]+"})
     */
    public function show(Property $property, $slug)
    {
        if ($slug !== $property->getSlug())
        {
            return $this->redirectToRoute("property.show", [
                "id" => $property->getId(),
                "slug" => $property->getSlug()
            ], 301);
        }
        return $this->render("property/show.html.twig", [
            "current_menu" => "properties",
            "property" => $property
        ]);
    }
}
