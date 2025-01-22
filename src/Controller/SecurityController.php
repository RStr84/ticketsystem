<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $utils): Response
    {
//        dd($utils->getLastAuthenticationError());
        return $this->render('login/index.html.twig', ['error' => $utils->getLastAuthenticationError()]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout() {
        // dd bzw. logout() wird nie ausgeführt
        dd('logout');
    }

    #[Route('/', name: 'app_home')]
    public function home() {
        dd('Home');
    }
}
