<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SecurityController extends AbstractController
{
    /**
     * @var Symfony\Component\Security\Http\Authentication\AuthenticationUtils
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authUtil)
    {
        $error = $authUtil->getLastAuthenticationError();
        $lastUsername = $authUtil->getLastUsername();
        return $this->render('security/login.html.twig', [
            'current_menu' => 'login',
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }
}
