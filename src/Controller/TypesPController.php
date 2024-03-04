<?php

// src/Controller/TypesPController.php

namespace App\Controller;

use App\Entity\TypesP;
use App\Form\TypesPType;
use App\Repository\TypesPRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypesPController extends AbstractController
{
    /**
     * @Route("/types", name="types_index", methods={"GET"})
     */
    public function index(TypesPRepository $typesPRepository): Response
    {
        $types = $typesPRepository->findAll();

        return $this->render('types_p/index.html.twig', [
            'types' => $types,
        ]);
    }
    /**
     * @Route("/types/new", name="types_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $type = new TypesP();
        $form = $this->createForm(TypesPType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('types_index');
        }

        return $this->render('types_p/new.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/types/{id}", name="types_show", methods={"GET", "POST"})
     */
    public function show(TypesP $type): Response
    {
        return $this->render('types_p/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/types/{id}/edit", name="types_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypesP $type): Response
    {
        $form = $this->createForm(TypesPType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('types_index');
        }

        return $this->render('types_p/edit.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/types/{id}", name="types_delete", methods={"POST"})
     */
    public function delete(Request $request, TypesP $type): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('types_index');
    }
}

