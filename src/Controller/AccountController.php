<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountEditType;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/change_password', name: 'app_change_password')]
    public function change_password(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
            if ($passwordEncoder->isPasswordValid($user, $old_pwd)) { // $user works fine
                $new_pwd = $form->get('new_password')->getData();
                $password = $passwordEncoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $entityManager->flush();
            }
        }

        return $this->render('security/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
