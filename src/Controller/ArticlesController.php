<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticleCategoriesRepository;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/index{name}", name="articles_index", methods={"GET"})
     */
    public function index(Request $request,$name,ArticlesRepository $articlesRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $titre = $request->get('text');
            $articles = $articlesRepository->findajaxArticles($titre, $name);
            return new JsonResponse([
                'content' => $this->renderView('articles/_contentArticles.html.twig', compact('articles','name'))
            ]);
        }
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findByCategorie($name),
            'categorieEnCours'=>$name
        ]);
    }

    /**
     * @Route("/new{cat}", name="articles_new", methods={"GET", "POST"})
     */
    public function new(Request $request,$cat, EntityManagerInterface $entityManager,ArticleCategoriesRepository $articleCategoriesRepository): Response
    {
        $categorie = $articleCategoriesRepository->findOneBy(['name'=>$cat]);
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCategorie($categorie);
            $article->setCreatedDate(new \DateTime('now'));
            if ($form->get('imageEnAvant')->getData() != null) {
                $image = $form->get('imageEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $article->setImageEnAvant($fichier);
            }
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('articles_index', ['name'=>$cat], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'cat'=>$cat,
            'form' => $form,
        ]);
    }



    /**
     * @Route("/{id}/edit/", name="articles_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,Articles $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('imageEnAvant')->getData() != null) {
                $image = $form->get('imageEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $article->getImageEnAvant());
                $article->setImageEnAvant($fichier);
            }

            $entityManager->flush();
            return $this->redirectToRoute('articles_index', ['name'=>$article->getCategorie()->getName()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/{name}", name="articles_delete", methods={"POST"})
     */
    public function delete($name,Request $request, Articles $article, EntityManagerInterface $entityManager): Response
    {

        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('images_directory') . '/' . $article->getImageEnAvant());
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_index', ['name'=>$name], Response::HTTP_SEE_OTHER);
    }
}
