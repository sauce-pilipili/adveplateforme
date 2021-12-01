<?php

namespace App\Controller;

use App\Entity\Centres;
use App\Form\CentresType;
use App\Repository\CentresCategoriesRepository;
use App\Repository\CentresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centres")
 */
class CentresController extends AbstractController
{
    /**
     * @Route("/index{name}", name="centres_index", methods={"GET"})
     */
    public function index(Request $request, $name,CentresRepository $centresRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $titre = $request->get('text');
            $centres = $centresRepository->findajaxCentre($titre, $name);
            return new JsonResponse([
                'content' => $this->renderView('centres/_contentCentres.html.twig', compact('centres','name'))
            ]);
        }

        return $this->render('centres/index.html.twig', [
            'centres' => $centresRepository->findByCategorie($name),
            'centreEnCours'=>$name,
        ]);
    }

    /**
     * @Route("/new/{centrecat}", name="centres_new", methods={"GET", "POST"})
     */
    public function new(Request $request,$centrecat, EntityManagerInterface $entityManager, CentresCategoriesRepository $centresCategoriesRepository): Response
    {
        $categorie = $centresCategoriesRepository->findOneBy(['name'=>$centrecat]);
        $centre = new Centres();
        $form = $this->createForm(CentresType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $centre->setCategorieCentre($categorie);
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $centre->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoCadre')->getData() != null) {
                $image = $form->get('photoCadre')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $centre->setPhotoCadre($fichier);
            }
            if ($form->get('photoEncadrement')->getData() != null) {
                $image = $form->get('photoEncadrement')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $centre->setPhotoEncadrement($fichier);
            }

            $entityManager->persist($centre);
            $entityManager->flush();

            return $this->redirectToRoute('centres_index', ['name'=>$centrecat], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres/new.html.twig', [
            'cat'=>$centrecat,
            'centre' => $centre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centres_show", methods={"GET"})
     */
    public function show(Centres $centre): Response
    {
        return $this->render('centres/show.html.twig', [
            'centre' => $centre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centres_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Centres $centre, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(CentresType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $centre->getPhotoEnAvant());
                $centre->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoCadre')->getData() != null) {
                $image = $form->get('photoCadre')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $centre->getPhotoCadre());
                $centre->setPhotoCadre($fichier);
            }
            if ($form->get('photoEncadrement')->getData() != null) {
                $image = $form->get('photoEncadrement')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $centre->getPhotoEncadrement());
                $centre->setPhotoEncadrement($fichier);
            }
            $entityManager->flush();

            return $this->redirectToRoute('centres_index', ['name'=>$centre->getCategorieCentre()->getName()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centres/edit.html.twig', [
            'centre' => $centre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centres_delete", methods={"POST"})
     */
    public function delete(Request $request, Centres $centre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centre->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('images_directory') . '/' . $centre->getPhotoEncadrement());
            unlink($this->getParameter('images_directory') . '/' . $centre->getPhotoEnAvant());
            unlink($this->getParameter('images_directory') . '/' . $centre->getPhotoCadre());
            $entityManager->remove($centre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centres_index', ['name'=>$centre->getCategorieCentre()->getName()], Response::HTTP_SEE_OTHER);
    }
}
