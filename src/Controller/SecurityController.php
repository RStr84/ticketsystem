<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/login')]
final class SecurityController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('login/index.html.twig', [
        ]);
    }
}
