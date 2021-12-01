<?php

namespace App\Controller;

use App\Entity\Sejours;
use App\Form\SejoursType;
use App\Repository\SejoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sejours")
 */
class SejoursController extends AbstractController
{
    /**
     * @Route("/", name="sejours_index", methods={"GET"})
     */
    public function index(Request $request,SejoursRepository $sejoursRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $titre = $request->get('text');
            $sejours = $sejoursRepository->findajaxSejours($titre);
            return new JsonResponse([
                'content' => $this->renderView('sejours/_contentSejours.html.twig', compact('sejours'))
            ]);
        }

        return $this->render('sejours/index.html.twig', [
            'sejours' => $sejoursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sejours_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sejour = new Sejours();
        $form = $this->createForm(SejoursType::class, $sejour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $sejour->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoCadre')->getData() != null) {
                $image = $form->get('photoCadre')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $sejour->setPhotoCadre($fichier);
            }
            if ($form->get('photoEncadrement')->getData() != null) {
                $image = $form->get('photoEncadrement')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $sejour->setPhotoEncadrement($fichier);
            }

            $entityManager->persist($sejour);
            $entityManager->flush();

            return $this->redirectToRoute('sejours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sejours/new.html.twig', [
            'sejour' => $sejour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sejours_show", methods={"GET"})
     */
    public function show(Sejours $sejour): Response
    {
        return $this->render('sejours/show.html.twig', [
            'sejour' => $sejour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sejours_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sejours $sejour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SejoursType::class, $sejour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('photoEnAvant')->getData() != null) {
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $sejour->getPhotoEnAvant());
                $sejour->setPhotoEnAvant($fichier);
            }
            if ($form->get('photoCadre')->getData() != null) {
                $image = $form->get('photoCadre')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $sejour->getPhotoCadre());
                $sejour->setPhotoCadre($fichier);
            }
            if ($form->get('photoEncadrement')->getData() != null) {
                $image = $form->get('photoEncadrement')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                unlink($this->getParameter('images_directory') . '/' . $sejour->getPhotoEncadrement());
                $sejour->setPhotoEncadrement($fichier);
            }
            $entityManager->flush();

            return $this->redirectToRoute('sejours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sejours/edit.html.twig', [
            'sejour' => $sejour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sejours_delete", methods={"POST"})
     */
    public function delete(Request $request, Sejours $sejour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sejour->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('images_directory') . '/' . $sejour->getPhotoEnAvant());
            unlink($this->getParameter('images_directory') . '/' . $sejour->getPhotoCadre());
            unlink($this->getParameter('images_directory') . '/' . $sejour->getPhotoEncadrement());
            $entityManager->remove($sejour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sejours_index', [], Response::HTTP_SEE_OTHER);
    }
}
