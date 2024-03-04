<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produits;
use App\Entity\Panier;


class PanierController extends AbstractController
{
    public function addToCart(Request $request, SessionInterface $session): Response
    {
        $productId = $request->request->get('productId');
        $quantity = $request->request->get('quantity');

        $product = $this->getDoctrine()->getRepository(Produits::class)->find($productId);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        $panier = new Panier();
        $panier->setProduit($product);
        $panier->setQuantite($quantity);
        $panier->setDateAjout(new \DateTime());

        // Ajoutez le panier à la session
        $cart = $session->get('cart', []);
        $cart[] = $panier;
        $session->set('cart', $cart);

        return $this->redirectToRoute('homepage'); // Redirigez où vous voulez
    }

    public function viewCart(SessionInterface $session): Response
    {
        // Récupérer le panier depuis la session
        $cart = $session->get('cart', []);

        // Nettoyer le panier en vérifiant la date d'ajout de chaque élément
        foreach ($cart as $index => $item) {
            if ($item->getDateAjout() < new \DateTime('-24 hours')) {
                unset($cart[$index]); // Supprimer l'élément du panier
            }
        }

        // Enregistrer le panier nettoyé dans la session
        $session->set('cart', $cart);

        // Afficher la vue du panier avec le panier nettoyé
        return $this->render('panier/view.html.twig', [
            'cart' => $cart
        ]);
    }
}
