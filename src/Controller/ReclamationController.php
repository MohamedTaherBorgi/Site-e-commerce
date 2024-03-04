<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Class\mail;
use Doctrine\Persistence\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Security\Core\Security;
use Twilio\Rest\Client;

class ReclamationController extends AbstractController
{
    // Add this property
    private $security;

    // Inject Security component into the controller
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/reclamation', name: 'reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/reclamation.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    #[Route('/addreclamation', name: 'addreclamation')]
    public function addreclamation(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        // Retrieve the currently logged-in user
        $user = $this->security->getUser();

        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associate the reclamation with the logged-in user
            $reclamation->setUser($user);

            $entityManager->persist($reclamation);
            $entityManager->flush();

            $this->addFlash('success', 'Réclamation envoyée avec succès !');

            return $this->redirectToRoute('addreclamation');
        }

        return $this->render('reclamation/addreclamation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

// Envoi du message Twilio
    /*
     $sid    = "ACd6d77606027e6e2fd9e24e08de557375";
     $token  = "4076d52f3372b4b14d1f4f4d5c05f585";
     $twilio = new Client($sid, $token);

     $message = $twilio->messages
         ->create("+216".$reclamation->getTelephone(),
             array(
                 "from" => "+12765288777",
                 "body" => "Bonjour, merci d'avoir contacté notre service de réclamation, nous sommes désolés pour tout inconvénient que vous avez rencontré. Votre satisfaction est notre priorité.
                 Nous vous repondrons dans les plus bref délais. Merci pour votre patience et votre compréhension."
             )
         );

     print($message->sid);
    */


    #[Route('/showreclamation', name: 'showreclamation')]
    public function showreclamation(ReclamationRepository $reclamationRepository): Response
    {
        // Retrieve the currently logged-in user
        $user = $this->security->getUser();

        // Retrieve reclamations associated with the logged-in user
        $reclamations = $reclamationRepository->findBy(['user' => $user]);

        return $this->render('reclamation/showreclamation.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/updatereclamation/{id}', name: 'updatereclamation')]
    public function updatereclamation($id, ReclamationRepository $repo, Request $request, EntityManagerInterface $entityManager)
    {
        $reclamation = $repo->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        // $form->add('Enregistrer', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('showreclamation', ['id' => $reclamation->getId()]);
        }

        return $this->render('reclamation/updatereclamation.html.twig', [
            'form' => $form->createView(),
            'id' => $id, // Passer l'identifiant de la réclamation à la vue Twig
        ]);
    }


    #[Route('/deletereclamation/{id}', name: 'deletereclamation')]
    public function deletereclamation($id, ReclamationRepository $repo, EntityManagerInterface $entityManager)
    {
        $reclamation = $repo->find($id);

        if ($reclamation !== null) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('showreclamation');
    }

    #[Route('/pdffront', name: 'pdffront', methods: 'GET')]
    public function pdffront(ReclamationRepository $reclamationRepository): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $reclamations = $reclamationRepository->findAll();


        $html = $this->renderView('reclamation/pdffront.html.twig', [
            'reclamations' => $reclamations,
        ]);

        $dompdf->load_html($html);

        $dompdf->setPaper('A2');

        $dompdf->render();

        $dompdf->stream("mes reclamations.pdf", [
            "Attachement" => true
        ]);

        $reclamations = $reclamationRepository->findAll();


        return $this->render('reclamation/pdffront.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/ajaxsearch', name: 'ajaxsearch')]
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $reclamation = $em->getRepository(Reclamation::class)->findEntitiesByString($requestString);

        if (!$reclamation) {
            $result['reclamation']['error'] = "reclamation introuvable :( ";

        } else {
            $result['reclamation'] = $this->getRealEntities($reclamation);
        }
        return new Response(json_encode($result));

    }

    public function getRealEntities($reclamation)
    {
        foreach ($reclamation as $reclamation) {
            $realEntities[$reclamation->getId()] = [$reclamation->getEmail()];

        }
        return $realEntities;
    }


}
