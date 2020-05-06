<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Evolution;
use App\Form\CommentsType;
use App\Form\EvolutionType;
use App\Form\VoteType;
use App\Repository\EvolutionRepository;
use App\Entity\Vote;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/evolution")
 */
class EvolutionController extends AbstractController
{
    /**
     * @Route("/", name="evolution_index", methods={"GET"})
     */
    public function index(EvolutionRepository $evolutionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $evolution = $paginator->paginate(
            $evolutionRepository->findAllEvolutionQuery(),
            $request->query->getInt('page', 1), 12);

        return $this->render('evolution/index.html.twig', [
            'evolutions' => $evolution
        ]);
    }

    /**
     * @Route("/new", name="evolution_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evolution = new Evolution();
        $form = $this->createForm(EvolutionType::class, $evolution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evolution->setDate(new \DateTime());

            //Récupère l'id de l'utilisateur lié a la création de l'evolution
            $evolution->setUserEvolution($this->getUser());


            //Create the object Vote and save at the BD
            $vote = new Vote();
            $vote->setLikes(0);
            $vote->setDislikes(0);
            $vote->setEvolution($evolution);
            $evolution->setVote($vote);
            $entityManagerVote = $this->getDoctrine()->getManagerForClass(Vote::class);
            $entityManagerVote->persist($vote);
            $entityManagerVote->flush();


            $entityManagerEvolution = $this->getDoctrine()->getManager();
            $entityManagerEvolution->persist($evolution);
            $entityManagerEvolution->flush();


            return $this->redirectToRoute('evolution_index');
        }

        return $this->render('evolution/new.html.twig', [
            'evolution' => $evolution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="evolution_show", requirements={"slug": "[a-z0-9\-]*"})
     * @ParamConverter("evolution", options={"mapping": {"id" = "id", "slug" = "slug"}})
     */

    public function show(Evolution $evolution, string $slug, Request $request): Response
    {
        $entityManagerVote = $this->getDoctrine()->getManagerForClass(Vote::class);
        $voteRepository = $entityManagerVote->getRepository(Vote::class);
        $vote = $voteRepository->find($evolution->getVote());

        //Vote system
        $formVote = $this->createForm(VoteType::class, $vote);
        $formVote->handleRequest($request);
        if ($formVote->isSubmitted() && $formVote->isValid()) {
            $userId = $this->getUser()->getId();
            if (!is_null($this->getUser())) {
                if ($request->request->get('likeButton')) {
                    if (in_array($userId, $vote->getUserLikeTab()) === false && in_array($userId, $vote->getUserDislikeTab()) === false ) {
                        $vote->setLikes($vote->getLikes() + 1);
                        $vote->setUserLikeTab($userId);
                    } elseif (in_array($userId, $vote->getUserLikeTab()) === false && in_array($userId, $vote->getUserDislikeTab())){
                        $vote->setLikes($vote->getLikes() + 1);
                        $vote->setDisLikes($vote->getDisLikes() - 1);
                        $vote->setUserLikeTab($userId);
                        $key = array_search($userId, $vote->getUserDislikeTab());
                        $vote->removeUserDislikeTab($key);
                    }
                } elseif ($request->request->get('dislikeButton')) {
                    if (in_array($userId, $vote->getUserDislikeTab()) === false && in_array($userId, $vote->getUserLikeTab()) === false) {
                        $vote->setDisLikes($vote->getDisLikes() + 1);
                        $vote->setUserDislikeTab($userId);
                    } elseif (in_array($userId, $vote->getUserDislikeTab()) === false && in_array($userId, $vote->getUserLikeTab())) {
                        $vote->setDisLikes($vote->getDisLikes() + 1);
                        $vote->setLikes($vote->getLikes() - 1);
                        $vote->setUserDislikeTab($userId);
                        $key = array_search($userId, $vote->getUserLikeTab());
                        $vote->removeUserLikeTab($key);
                    }
                }
                $entityManagerVote->persist($vote);
                $entityManagerVote->flush();
            }
        }

        //create comment
        $comments = new Comments();
        $form = $this->createForm(CommentsType::class, $comments);
        $form->handleRequest($request);
        $entityManagerComments = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $comments->setUserComments($this->getUser());
            $comments->setCreated(new \DateTime());
            $comments->setEvolution($evolution);
            $entityManagerComments->persist($comments);
            $entityManagerComments->flush();

            return $this->redirectToRoute('evolution_show', [
                'id' => $evolution->getId(),
                'slug' => $evolution->getSlug()
            ], 301);
        }


        if ($evolution->getSlug() !== $slug) {
            return $this->redirectToRoute('evolution_show', [
                'id' => $evolution->getId(),
                'slug' => $evolution->getSlug()
            ], 301);
        }
        return $this->render('evolution/show.html.twig', [
            'evolution' => $evolution,
            'vote' => $vote,
            'commentsForm' => $form->createView(),
            'voteForm' => $formVote->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evolution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evolution $evolution): Response
    {
        $this->denyAccessUnlessGranted('edit', $evolution);
        $form = $this->createForm(EvolutionType::class, $evolution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evolution_index', [
                'id' => $evolution->getId(),
            ]);
        }

        return $this->render('evolution/edit.html.twig', [
            'evolution' => $evolution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evolution_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evolution $evolution): Response
    {
        $this->denyAccessUnlessGranted('delete', $evolution);
        if ($this->isCsrfTokenValid('delete' . $evolution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evolution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evolution_index');
    }
}
