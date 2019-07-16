<?php

namespace App\Controller;

use App\Entity\Base1;
use App\Form\Base1Type;
use App\Repository\Base1Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/base1")
 */
class Base1Controller extends AbstractController
{
    /**
     * @Route("/", name="base1_index", methods={"GET"})
     */
    public function index(Base1Repository $base1Repository): Response
    {
        return $this->render('base1/index.html.twig', [
            'base1s' => $base1Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="base1_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base1 = new Base1();
        $form = $this->createForm(Base1Type::class, $base1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($base1);
            $entityManager->flush();

            return $this->redirectToRoute('base1_index');
        }

        return $this->render('base1/new.html.twig', [
            'base1' => $base1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="base1_show", methods={"GET"})
     */
    public function show(Base1 $base1): Response
    {
        return $this->render('base1/show.html.twig', [
            'base1' => $base1,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="base1_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Base1 $base1): Response
    {
        $form = $this->createForm(Base1Type::class, $base1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('base1_index');
        }

        return $this->render('base1/edit.html.twig', [
            'base1' => $base1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="base1_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Base1 $base1): Response
    {
        if ($this->isCsrfTokenValid('delete'.$base1->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($base1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('base1_index');
    }
}
