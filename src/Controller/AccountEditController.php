<?php

namespace App\Controller;

use App\Form\AccountEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountEditController extends AbstractController
{
    #[Route('/account_edit', name: 'app_account_edit')]
    public function account_edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            //$entityManager->persist($user); //Freeze the data (kinda like -git commit)
            $entityManager->flush(); //Execute Queries

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/account_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
