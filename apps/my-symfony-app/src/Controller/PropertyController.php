<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FilterPropertiesType;
use App\Entity\FilterProperties;

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
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $form = $this->createForm(FilterPropertiesType::class, new FilterProperties());
        $properties = $paginator->paginate(
            $this->repository->findAllUnsoldQuery(),
            $request->query->getInt("page", 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'formFilter' => $form->createView(),
            'current_menu' => "property",
            'properties' => $properties
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
