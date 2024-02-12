<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/products', name: 'app_products')]
    public function products(): Response
    {
        return $this->render('products.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }

    #[Route('/login_register', name: 'app_login_register')]
    public function login_register(): Response
    {
        return $this->render('login_register.html.twig');
    }

    #[Route('/about-us', name: 'app_about-us')]
    public function about_us(): Response
    {
        return $this->render('about-us.html.twig');
    }

    #[Route('/shopping-cart', name: 'app_shopping-cart')]
    public function shopping_cart(): Response
    {
        return $this->render('shopping-cart.html.twig');
    }

    #[Route('/pay', name: 'app_pay')]
    public function pay(): Response
    {
        return $this->render('pay.html.twig');
    }
}