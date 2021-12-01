<?php

namespace App\Controller;

use App\Entity\CentresCategories;
use App\Form\CentresCategoriesType;
use App\Repository\CentresCategoriesRepository;
use App\Repository\CentresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centres/categories")
 */
class CentresCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="centres_categories_index", methods={"GET"})
     */
    public function index(Request $request,CentresCategoriesRepository $centresCategoriesRepository, CentresRepository $centresRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $cat = $request->get('cat');
            $count = $centresRepository->count($cat);
            return new JsonResponse([
                'counter' => $count
            ]);
        }

        return $this->render('centres_categories/index.html.twig', [
            'centres_categories' => $centresCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="centres_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $centresCategory = new CentresCategories();
        $form = $this->createForm(CentresCategoriesType::class, $centresCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($centresCategory);
            $entityManager->flush();

            return $this->redirectToRoute('centres_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres_categories/new.html.twig', [
            'centres_category' => $centresCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centres_categories_show", methods={"GET"})
     */
    public function show(CentresCategories $centresCategory): Response
    {
        return $this->render('centres_categories/show.html.twig', [
            'centres_category' => $centresCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centres_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CentresCategories $centresCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CentresCategoriesType::class, $centresCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('centres_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres_categories/edit.html.twig', [
            'centres_category' => $centresCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centres_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, CentresCategories $centresCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centresCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($centresCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centres_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
