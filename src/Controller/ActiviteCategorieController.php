<?php

namespace App\Controller;

use App\Entity\ActiviteCategorie;
use App\Form\ActiviteCategorieType;
use App\Repository\ActiviteCategorieRepository;
use App\Repository\ActivitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activite/categorie")
 */
class ActiviteCategorieController extends AbstractController
{
    /**
     * @Route("/", name="activite_categorie_index", methods={"GET"})
     */
    public function index(Request $request,ActiviteCategorieRepository $activiteCategorieRepository,ActivitesRepository $activitesRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $cat = $request->get('cat');
            $count = $activitesRepository->count($cat);
            return new JsonResponse([
                'counter' => $count
            ]);
        }

        return $this->render('activite_categorie/index.html.twig', [
            'activite_categories' => $activiteCategorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="activite_categorie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activiteCategorie = new ActiviteCategorie();
        $form = $this->createForm(ActiviteCategorieType::class, $activiteCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activiteCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('activite_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite_categorie/new.html.twig', [
            'activite_categorie' => $activiteCategorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="activite_categorie_show", methods={"GET"})
     */
    public function show(ActiviteCategorie $activiteCategorie): Response
    {
        return $this->render('activite_categorie/show.html.twig', [
            'activite_categorie' => $activiteCategorie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activite_categorie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ActiviteCategorie $activiteCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActiviteCategorieType::class, $activiteCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('activite_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite_categorie/edit.html.twig', [
            'activite_categorie' => $activiteCategorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="activite_categorie_delete", methods={"POST"})
     */
    public function delete(Request $request, ActiviteCategorie $activiteCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activiteCategorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activiteCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activite_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
