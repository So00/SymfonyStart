<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use App\Entity\Property as HomeProperty;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $property;

    /**
     * @var Doctrine\Common\Persistence\ObjectManager
     */
    private $em;
    
    function __construct(PropertyRepository $property, ObjectManager $em)
    {
        $this->property = $property;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.index")
     */
    public function index()
    {
        $properties = $this->property->findAll();
        return $this->render('admin/index.html.twig', [
            "current_menu" => "admin",
            "properties" => $properties
        ]);
    }

    /**
     * @var App/Entity/Property;
     * @Route("/admin/{id}", name="admin.edit", requirements={"id":"[0-9]+"}, methods="GET|POST")
     */
    public function edit(HomeProperty $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Votre bien a bien été modifié');
            return $this->redirectToRoute("admin.index");
        }
        return $this->render('admin/edit.html.twig', [
            "current_menu" => "admin",
            "property" => $property,
            "form" => $form->createView()
        ]);
    }

    /**
     * @var App/Entity/Property
     * @var Symfony\Component\HttpFoundation\Request
     * @Route("/admin/{id}", name="admin.delete", requirements={"id":"[0-9]+"}, methods="DELETE")
     */
    public function delete(HomeProperty $property, Request $request)
    {
        if ($this->isCsrfTokenValid("delete" . $property->getId(), $request->get("_token")))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Votre bien a bien été supprimé');
        }
        return $this->redirectToRoute("admin.index");
    }

    /**
     * @Route("/admin/creer", name="admin.create")
     */
    public function new(Request $request)
    {
        $property = new HomeProperty();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Votre bien a bien été créé');
            return $this->redirectToRoute("admin.index");
        }
        return $this->render('admin/create.html.twig', [
            "current_menu" => "admin",
            "property" => $property,
            "form" => $form->createView()
        ]);
    }
}
