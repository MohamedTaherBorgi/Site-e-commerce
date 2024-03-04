<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Manager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reclamation;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Reponse;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use App\Form\ReclamationType;
use App\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'admin')]
    public function admin(Request $request, ReclamationRepository $reclamationRepository, ReponseRepository $reponseRepository): Response
    {
        $order = $request->query->get('order', 'ASC');
        $triParNom = $request->query->get('tri_par_nom', false);
        $triParEtat = $request->query->get('etat', 'all');  // Mettez à jour le nom du paramètre de requête pour correspondre à votre template Twig

        $reclamations = $reclamationRepository->findAll();

        if ($triParNom) {
            $reclamations = $this->trierReclamationsParNom($reclamations, $order);
        } elseif ($triParEtat !== 'all') {
            // Filtrer les réclamations en fonction de l'état sélectionné
            $reclamations = array_filter($reclamations, function ($reclamation) use ($triParEtat) {
                return $reclamation->getEtat() === $triParEtat;
            });
        } else {
            $reclamations = $this->trierReclamations($reclamations, $order);
        }


        // Récupérer le nombre de réclamations dans chaque état
        $nbReclamationsTraitees = $reclamationRepository->countByEtat('traitée');
        $nbReclamationsEnCours = $reclamationRepository->countByEtat('en cours de traitement');


        $reponses = $reponseRepository->findAll();
        $reponses = $this->trierReponses($reponses, $order);

        // Passer les réclamations et les réponses triées au template Twig
        return $this->render('admin/admin.html.twig', [
            'reclamations' => $reclamations,
            'reponses' => $reponses,
            'nbReclamationsTraitees' => $nbReclamationsTraitees,
            'nbReclamationsEnCours' => $nbReclamationsEnCours,
        ]);
    }


    #[Route('/deleteadmin/{id}', name: 'deleteadmin')]
    public function deleteadmin($id, ReclamationRepository $repo, EntityManagerInterface $entityManager)
    {
        $reclamation = $repo->find($id);

        if ($reclamation !== null) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin');
    }

    #[Route('/deleteadminrep/{id}', name: 'deleteadminrep')]
    public function deleteadminrep($id, ReponseRepository $repo, EntityManagerInterface $entityManager)
    {
        $reponse = $repo->find($id);

        if ($reponse !== null) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin');
    }


    #[Route('/updateadmin/{id}', name: 'updateadmin')]
    public function updateadmin($id, ReclamationRepository $repo, Request $request, EntityManagerInterface $entityManager)
    {
        $reclamation = $repo->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        // $form->add('Enregistrer', SubmitType::class);
        $form = $this->createForm(ReclamationType::class, $reclamation, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin', ['id' => $reclamation->getId()]);
        }

        return $this->render('admin/updateadmin.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }


    #[Route('/updateadminrep/{id}', name: 'updateadminrep')]
    public function updateadminrep($id, ReponseRepository $repo, Request $request, EntityManagerInterface $entityManager)
    {
        $reponse = $repo->find($id);
        $form = $this->createForm(ReponseType::class, $reponse, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin', ['id' => $reponse->getId()]);
        }

        return $this->render('admin/updateadminrep.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }


    private function trierReclamations(array $reclamations, string $order): array
    {
        if ($order === 'ASC') {
            // ordre croissant
            usort($reclamations, function ($a, $b) {
                return $a->getId() - $b->getId();
            });
        } else {
            // ordre décroissant
            usort($reclamations, function ($a, $b) {
                return $b->getId() - $a->getId();
            });
        }

        return $reclamations;
    }


    private function trierReclamationsParNom(array $reclamations, string $order): array
    {
        // Si l'ordre est croissant
        if ($order === 'ASC') {
            //  ordre croissant
            usort($reclamations, function ($a, $b) {
                return strcmp(strtolower($a->getNom()), strtolower($b->getNom()));
            });
        } else {
            //ordre décroissant
            usort($reclamations, function ($a, $b) {
                return strcmp(strtolower($b->getNom()), strtolower($a->getNom()));
            });
        }

        return $reclamations;
    }


    private function trierReponses(array $reponses, string $order): array
    {
        if ($order === 'ASC') {
            // Tri par ordre croissant
            usort($reponses, function ($a, $b) {
                return $a->getId() - $b->getId();
            });
        } else {
            // Tri par ordre décroissant
            usort($reponses, function ($a, $b) {
                return $b->getId() - $a->getId();
            });
        }

        return $reponses;
    }


    #[Route('/rechercherRec', name: 'rechercherRec')]
    public function rechercherRec(Request $request, ReclamationRepository $reclamationRepository, ReponseRepository $reponseRepository): Response
    {
        // Récupérer l'ID depuis la requête
        $id = $request->query->get('id');

        // Rechercher la réclamation par ID
        $reclamation = $reclamationRepository->find($id);

        // Vérifier si la réclamation a été trouvée
        if ($reclamation === null) {
            // Si la réclamation n'est pas trouvée, retourner une réponse JSON avec un message d'erreur
            return new JsonResponse(['error' => 'La réclamation avec cet ID n\'existe pas'], 404);
        }

        // Rechercher les réponses associées à la réclamation
        $reponses = $reponseRepository->findBy(['reclamation' => $reclamation]);

        // Retourner une réponse JSON avec la réclamation trouvée et ses réponses associées
        return new JsonResponse(['reclamation' => $reclamation, 'reponses' => $reponses]);
    }

    #[Route('/pdfadmin', name: 'pdfadmin', methods: 'GET')]
    public function pdfadmin(ReclamationRepository $reclamationRepository, ReponseRepository $reponseRepository): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $reclamations = $reclamationRepository->findAll();
        $reponses = $reponseRepository->findAll();


        $html = $this->renderView('admin/pdfadmin.html.twig', [
            'reclamations' => $reclamations,
            'reponses' => $reponses,
        ]);

        $dompdf->load_html($html);

        $dompdf->setPaper('A2');

        $dompdf->render();

        $dompdf->stream("mypdf.pdf", [
            "Attachement" => true
        ]);

        $reclamations = $reclamationRepository->findAll();
        $reponses = $reponseRepository->findAll();


        return $this->render('admin/pdfadmin.html.twig', [
            'reclamations' => $reclamations,
            'reponses' => $reponses,
        ]);
    }

}

