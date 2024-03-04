<?php

namespace App\Controller;

use App\Class\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset_password', name: 'app_reset_password')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        if ($request->get('email')) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);
            if ($user) {
                // Save request to reset pwd
                $reset_pwd = new ResetPassword();
                $reset_pwd->setUser($user);
                $reset_pwd->setToken(uniqid());
                $reset_pwd->setCreatedAt(new \DateTime());
                $entityManager->persist($reset_pwd);
                $entityManager->flush();

                // Send Email with a link to update pwd
                $url = $this->generateUrl('app_update_password', [
                    'token' => $reset_pwd->getToken()
                ]);

                $content = "Bonjour " . $user->getFirstname() . ',' . "<br><br>Vous avez demandé la réinitialisation de votre mot de passe sur Ecosanté.<br><br>";
                $content .= "Merci de cliquer sur le lien suivant <a href='" . $url . "'> pour mettre à jour votre mot de passe";
                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname(), 'Réinitialiser mot de passe sue Ecosanté', $content);
                $this->addFlash('notice', "Vous allez recevoir un email.");
            } else {
                $this->addFlash('notice', "Cette adresse email n'existe pas.");
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

    #[Route('/update_password/{token}', name: 'app_update_password')]
    public function update(Request $request, $token, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $reset_pwd = $entityManager->getRepository(ResetPassword::class)->findOneBy(['token' => $request->get('token')]);

        if (!$reset_pwd) {
            return $this->redirectToRoute('app_reset_password');
        }
        // Verif if createdAt = now + 3h
        $now = new \DateTime();
        if ($now > $reset_pwd->getCreatedAt()->modify('+ 3 hour')) {
            $this->addFlash('notice', "Votre demande de réinitialisation à expiré.");
            return $this->redirectToRoute('app_reset_password');
        }
        // Render vue with new password and confirm password
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_pwd = $form->get('new_password')->getData();
            // encode pwd
            $password = $passwordEncoder->hashPassword($reset_pwd->getUser(), $new_pwd);
            $reset_pwd->getUser()->setPassword($password);
            //flush persist
            $entityManager->flush();
            //redirect login
            $this->addFlash('notice', 'Votre mot de passe est mis à jour.');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('reset_password/update.html.twig', ['form' => $form->createView()]);
    }
}
