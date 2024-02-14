<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

    #[Route('/buttons', name: 'app_buttons')]
    public function buttons(): Response
    {
        return $this->render('back/ui-buttons.html.twig');
    }

    #[Route('/icons', name: 'app_icons')]
    public function icons(): Response
    {
        return $this->render('back/icon-tabler.html.twig');
    }
}