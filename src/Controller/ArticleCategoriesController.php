<?php

namespace App\Controller;

use App\Entity\ArticleCategories;
use App\Form\ArticleCategoriesType;
use App\Repository\ArticleCategoriesRepository;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article/categories")
 */
class ArticleCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="article_categories_index", methods={"GET"})
     */
    public function index(Request $request,ArticleCategoriesRepository $articleCategoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $cat = $request->get('cat');
            $count = $articlesRepository->count($cat);
            return new JsonResponse([
                'counter' => $count
            ]);
        }
        return $this->render('article_categories/index.html.twig', [
            'article_categories' => $articleCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articleCategory = new ArticleCategories();
        $form = $this->createForm(ArticleCategoriesType::class, $articleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($articleCategory);
            $entityManager->flush();

            return $this->redirectToRoute('article_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_categories/new.html.twig', [
            'article_category' => $articleCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="article_categories_show", methods={"GET"})
     */
    public function show(ArticleCategories $articleCategory): Response
    {
        return $this->render('article_categories/show.html.twig', [
            'article_category' => $articleCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ArticleCategories $articleCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleCategoriesType::class, $articleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('article_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_categories/edit.html.twig', [
            'article_category' => $articleCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="article_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, ArticleCategories $articleCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($articleCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
