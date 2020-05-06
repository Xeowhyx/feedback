<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Entity\BugSearch;
use App\Entity\Priority;
use App\Entity\Severity;
use App\Entity\State;
use App\Form\BugSearchType;
use App\Form\BugType;
use App\Form\CommentsType;
use App\Entity\Comments;
use App\Repository\BugRepository;
use App\Repository\StateRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/bug")
 */
class BugController extends AbstractController
{
    /**
     * @Route("/", name="bug_index", methods={"GET"})
     */
    public function index(BugRepository $bugRepository, PaginatorInterface $paginator, Request $request): Response
    {
        //Filtrage des bugs
        $search = new BugSearch();
        $form = $this->createForm(BugSearchType::class, $search);
        $form->handleRequest($request);


        //Pagination des bugs
        $bug = $paginator->paginate(
            $bugRepository->findAllBugQuery($search),
            $request->query->getInt('page', 1), 20);

        //Rend a la vue
        return $this->render('bug/index.html.twig', [
            'bugs' => $bug,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="bug_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bug = new Bug();
        $form = $this->createForm(BugType::class, $bug);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bug->setUserBug($this->getUser());
            $bug->setDate(new \DateTime());
            $priority = new Priority();
            $priority->setName('A définir');
            $state = new State();
            $state->setName('Nouveau');
            $severity = new Severity();
            $severity->setName('A définir');
            $bug->setState($state);
            $bug->setPriority($priority);
            $bug->setSeverity($severity);

            $entityManager->persist($bug);
            $entityManager->flush();

            return $this->redirectToRoute('bug_index');
        }

        return $this->render('bug/new.html.twig', [
            'bug' => $bug,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="bug_show", methods={"GET", "POST"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Bug $bug, string $slug, Request $request, ObjectManager $objectManager): Response
    {
        $comments = new Comments();
        $form = $this->createForm(CommentsType::class,$comments);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $comments->setUserComments($this->getUser());
            $comments->setCreated(new \DateTime());
            $comments->setBug($bug);


            $objectManager->persist($comments);
            $objectManager->flush();
            return $this->redirectToRoute('bug_show', [
                'id' => $bug->getId(),
                'slug' => $bug->getSlug()
            ]);
        }
        if ($bug->getSlug() !== $slug) {
            return $this->redirectToRoute('bug_show', [
                'id' => $bug->getId(),
                'slug' => $bug->getSlug()
            ], 301);
        }

        return $this->render('bug/show.html.twig', [
            'bug' => $bug,
            'commentsForm'=> $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bug_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bug $bug): Response
    {
        $this->denyAccessUnlessGranted('edit', $bug);
        $form = $this->createForm(BugType::class, $bug);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bug_index', [
                'id' => $bug->getId(),
            ]);
        }

        return $this->render('bug/edit.html.twig', [
            'bug' => $bug,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bug_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bug $bug): Response
    {
        $this->denyAccessUnlessGranted('delete', $bug);
        if ($this->isCsrfTokenValid('delete'.$bug->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bug);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bug_index');
    }


}
