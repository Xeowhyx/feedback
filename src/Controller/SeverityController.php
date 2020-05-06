<?php

namespace App\Controller;

use App\Entity\Severity;
use App\Form\SeverityType;
use App\Repository\SeverityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/severity")
 */
class SeverityController extends AbstractController
{
    /**
     * @Route("/", name="severity_index", methods={"GET"})
     */
    public function index(SeverityRepository $severityRepository): Response
    {
        return $this->render('severity/index.html.twig', [
            'severities' => $severityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="severity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $severity = new Severity();
        $form = $this->createForm(SeverityType::class, $severity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($severity);
            $entityManager->flush();

            return $this->redirectToRoute('severity_index');
        }

        return $this->render('severity/new.html.twig', [
            'severity' => $severity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="severity_show", methods={"GET"})
     */
    public function show(Severity $severity): Response
    {
        return $this->render('severity/show.html.twig', [
            'severity' => $severity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="severity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Severity $severity): Response
    {
        $form = $this->createForm(SeverityType::class, $severity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('severity_index', [
                'id' => $severity->getId(),
            ]);
        }

        return $this->render('severity/edit.html.twig', [
            'severity' => $severity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="severity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Severity $severity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$severity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($severity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('severity_index');
    }
}
