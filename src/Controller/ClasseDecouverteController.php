<?php

namespace App\Controller;

use App\Entity\ClasseDecouverte;
use App\Form\ClasseDecouverteType;
use App\Repository\ClasseDecouverteCategorieRepository;
use App\Repository\ClasseDecouverteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classe/decouverte")
 */
class ClasseDecouverteController extends AbstractController
{
    /**
     * @Route("/{name}", name="classe_decouverte_index", methods={"GET"})
     */
    public function index(Request $request, $name,ClasseDecouverteRepository $classeDecouverteRepository): Response
    {

        if ($request->isXmlHttpRequest()) {
            $titre = $request->get('text');
            $classe_decouvertes = $classeDecouverteRepository->findajaxClasse($titre,$name);
            return new JsonResponse([
                'content' => $this->renderView('classe_decouverte/_contentClasseDecouverte.html.twig', compact('classe_decouvertes','name'))
            ]);
        }

        return $this->render('classe_decouverte/index.html.twig', [
            'classe_decouvertes' => $classeDecouverteRepository->findByCategorie($name),
            'classeEnCours'=>$name
        ]);
    }

    /**
     * @Route("/new/{classecat}", name="classe_decouverte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, $classecat, EntityManagerInterface $entityManager, ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository): Response
    {
        $classeDecouverte = new ClasseDecouverte();
        $form = $this->createForm(ClasseDecouverteType::class, $classeDecouverte);
        $form->handleRequest($request);
        $classeCategorie = $classeDecouverteCategorieRepository->findOneBy(['name'=>$classecat]);
        if ($form->isSubmitted() && $form->isValid()) {
            $classeDecouverte->setCategorie($classeCategorie);
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $classeDecouverte->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoClasse')->getData() != null) {
                $image = $form->get('photoClasse')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $classeDecouverte->setPhotoClasse($fichier);
            }

            $entityManager->persist($classeDecouverte);
            $entityManager->flush();

            return $this->redirectToRoute('classe_decouverte_index', ['name'=>$classecat], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classe_decouverte/new.html.twig', [
            'classe_decouverte' => $classeDecouverte,
            'form' => $form,
            'cat'=>$classecat,
        ]);
    }

    /**
     * @Route("/{id}", name="classe_decouverte_show", methods={"GET"})
     */
    public function show(ClasseDecouverte $classeDecouverte): Response
    {
        return $this->render('classe_decouverte/show.html.twig', [
            'classe_decouverte' => $classeDecouverte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classe_decouverte_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ClasseDecouverte $classeDecouverte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseDecouverteType::class, $classeDecouverte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $classeDecouverte->getPhotoEnAvant());
                $classeDecouverte->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoClasse')->getData() != null) {
                $image = $form->get('photoClasse')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $classeDecouverte->getPhotoClasse());
                $classeDecouverte->setPhotoClasse($fichier);
            }

            $entityManager->flush();
            return $this->redirectToRoute('classe_decouverte_index', ['name'=>$classeDecouverte->getCategorie()->getName()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classe_decouverte/edit.html.twig', [
            'classe_decouverte' => $classeDecouverte,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="classe_decouverte_delete", methods={"POST"})
     */
    public function delete(Request $request, ClasseDecouverte $classeDecouverte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeDecouverte->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('images_directory') . '/' . $classeDecouverte->getPhotoClasse());
            unlink($this->getParameter('images_directory') . '/' . $classeDecouverte->getPhotoEnAvant());
            $entityManager->remove($classeDecouverte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classe_decouverte_index', ['name'=>$classeDecouverte->getCategorie()->getName()], Response::HTTP_SEE_OTHER);
    }
}
