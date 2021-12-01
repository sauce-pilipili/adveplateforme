<?php

namespace App\Controller;

use App\Entity\Activites;
use App\Form\ActivitesType;
use App\Repository\ActiviteCategorieRepository;
use App\Repository\ActivitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activites")
 */
class ActivitesController extends AbstractController
{
    /**
     * @Route("/{name}", name="activites_index", methods={"GET"})
     */
    public function index(Request $request, $name, ActivitesRepository $activitesRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $titre = $request->get('text');
            $activites = $activitesRepository->findajaxActivite($titre, $name);
            return new JsonResponse([
                'content' => $this->renderView('activites/_contentActivite.html.twig', compact('activites', 'name'))
            ]);
        }

        return $this->render('activites/index.html.twig', [
            'activites' => $activitesRepository->findByCategorie($name),
            'categorieEnCours' => $name,
        ]);
    }

    /**
     * @Route("/new/{activitecat}", name="activites_new", methods={"GET", "POST"})
     */
    public function new(Request $request, $activitecat, ActiviteCategorieRepository $activiteCategorieRepository, EntityManagerInterface $entityManager): Response
    {
        $activite = new Activites();
        $form = $this->createForm(ActivitesType::class, $activite);
        $form->handleRequest($request);
        $activiteCategorie = $activiteCategorieRepository->findOneBy(['name' => $activitecat]);
        if ($form->isSubmitted() && $form->isValid()) {
            $activite->setCategorie($activiteCategorie);
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $activite->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoHistoire')->getData() != null) {
                $image = $form->get('photoHistoire')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $activite->setPhotoHistoire($fichier);
            }
            if ($form->get('photoDiscipline')->getData() != null) {
                $image = $form->get('photoDiscipline')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $activite->setPhotoDiscipline($fichier);
            }


            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('activites_index', ['name'=> $activitecat], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activites/new.html.twig', [
            'cat' => $activitecat,
            'activite' => $activite,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="activites_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Activites $activite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivitesType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $activite->getPhotoEnAvant());
                $activite->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoHistoire')->getData() != null) {
                $image = $form->get('photoHistoire')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $activite->getPhotoHistoire());
                $activite->setPhotoHistoire($fichier);
            }
            if ($form->get('photoDiscipline')->getData() != null) {
                $image = $form->get('photoDiscipline')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $activite->getPhotoDiscipline());
                $activite->setPhotoDiscipline($fichier);
            }

            $entityManager->flush();

            return $this->redirectToRoute('activites_index', ['name' => $activite->getCategorie()->getName()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activites/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
            'cat'=>$activite->getCategorie()->getName(),
        ]);
    }

    /**
     * @Route("/{id}", name="activites_delete", methods={"POST"})
     */
    public function delete(Request $request, Activites $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $activite->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('images_directory') . '/' . $activite->getPhotoDiscipline());
            unlink($this->getParameter('images_directory') . '/' . $activite->getPhotoHistoire());
            unlink($this->getParameter('images_directory') . '/' . $activite->getPhotoEnAvant());
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activites_index', ['name' => $activite->getCategorie()->getName()], Response::HTTP_SEE_OTHER);
    }
}
