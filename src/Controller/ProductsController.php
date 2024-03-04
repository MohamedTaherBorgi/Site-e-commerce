<?php

// src/Controller/ProduitsController.php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Entity\Panier;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits_index", methods={"GET"})
     */
    public function index(ProduitsRepository $produitsRepository): Response
    {
        $produits = $produitsRepository->findAll();

        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/front/produits", name="front_produits")
     */
    public function frontProduits(): Response
    {
        // Récupérez les produits depuis la base de données
        $produits = $this->getDoctrine()->getRepository(Produits::class)->findAll();

        return $this->render('front/products.html.twig', [
            'produits' => $produits, // Transmettez les produits à la vue
        ]);
    }

    /**
     * @Route("/produits/new", name="produits_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produits_index');
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/produits/{id}", name="produits_show", methods={"GET"})
     */
    public function show(ProduitsRepository $produitsRepository, $id): Response
    {
        $produit = $produitsRepository->find($id);

        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/produits/{id}/edit", name="produits_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produits $produit): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produits_index');
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produits/{id}", name="produits_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produits $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produits_index');
    }

     // Action pour ajouter un produit au panier
     public function addToCart(Request $request, $id): Response
     {
         $produit = $this->getDoctrine()->getRepository(Produits::class)->find($id);

         if (!$produit) {
             throw $this->createNotFoundException('Produit non trouvé');
         }

         $session = $request->getSession();
         $cart = $session->get('cart', []);

         // Ajouter le produit au panier
         $cart[] = $produit->getId();
         $session->set('cart', $cart);

         return $this->redirectToRoute('produits_index');
     }
}

