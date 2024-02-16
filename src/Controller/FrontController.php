<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    #[Route('/products', name: 'app_products')]
    public function products(): Response
    {
        return $this->render('front/products.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig');
    }

    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('front/register.html.twig');
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('front/login.html.twig');
    }

    #[Route('/about-us', name: 'app_about-us')]
    public function about_us(): Response
    {
        return $this->render('front/about-us.html.twig');
    }

    #[Route('/shopping-cart', name: 'app_shopping-cart')]
    public function shopping_cart(): Response
    {
        return $this->render('front/shopping-cart.html.twig');
    }

    #[Route('/pay', name: 'app_pay')]
    public function pay(): Response
    {
        return $this->render('front/pay.html.twig');
    }
}