<?php

namespace App\Controller;

use App\Entity\ClasseDecouverteCategorie;
use App\Form\ClasseDecouverteCategorieType;
use App\Repository\ClasseDecouverteCategorieRepository;
use App\Repository\ClasseDecouverteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classe/decouverte/categorie")
 */
class ClasseDecouverteCategorieController extends AbstractController
{
    /**
     * @Route("/", name="classe_decouverte_categorie_index", methods={"GET"})
     */
    public function index(Request $request,ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository, ClasseDecouverteRepository $classeDecouverteRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $cat = $request->get('cat');
            $count = $classeDecouverteRepository->count($cat);
            return new JsonResponse([
                'counter' => $count
            ]);
        }

        return $this->render('classe_decouverte_categorie/index.html.twig', [
            'classe_decouverte_categories' => $classeDecouverteCategorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="classe_decouverte_categorie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeDecouverteCategorie = new ClasseDecouverteCategorie();
        $form = $this->createForm(ClasseDecouverteCategorieType::class, $classeDecouverteCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeDecouverteCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('classe_decouverte_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classe_decouverte_categorie/new.html.twig', [
            'classe_decouverte_categorie' => $classeDecouverteCategorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="classe_decouverte_categorie_show", methods={"GET"})
     */
    public function show(ClasseDecouverteCategorie $classeDecouverteCategorie): Response
    {
        return $this->render('classe_decouverte_categorie/show.html.twig', [
            'classe_decouverte_categorie' => $classeDecouverteCategorie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classe_decouverte_categorie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ClasseDecouverteCategorie $classeDecouverteCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseDecouverteCategorieType::class, $classeDecouverteCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('classe_decouverte_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classe_decouverte_categorie/edit.html.twig', [
            'classe_decouverte_categorie' => $classeDecouverteCategorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="classe_decouverte_categorie_delete", methods={"POST"})
     */
    public function delete(Request $request, ClasseDecouverteCategorie $classeDecouverteCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeDecouverteCategorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($classeDecouverteCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_decouverte_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
