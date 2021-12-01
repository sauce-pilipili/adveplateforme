<?php

namespace App\Controller;

use App\Repository\ActiviteCategorieRepository;
use App\Repository\ActivitesRepository;
use App\Repository\ArticlesRepository;
use App\Repository\CentresCategoriesRepository;
use App\Repository\CentresRepository;
use App\Repository\ClasseDecouverteCategorieRepository;
use App\Repository\ClasseDecouverteRepository;
use App\Repository\DureeSejourRepository;
use App\Repository\SejoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class MainController extends AbstractController
{
    const EMAIL = 'admin@mail.fr';

    /**
     * @Route("/", name="main")
     */
    public function index(Request                             $request,
                          CentresCategoriesRepository         $centresCategoriesRepository,
                          ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                          ActiviteCategorieRepository         $activiteCategorieRepository,
                          ArticlesRepository                  $articlesRepository,
                          CentresRepository                   $centresRepository,

                          SejoursRepository                   $sejoursRepository,
                          ActivitesRepository                 $activitesRepository): Response
    {
        $articles = $articlesRepository->findTheThreeLast();
        $sejours = $sejoursRepository->findAllJointure();

        if ($request->isMethod('POST')) {
            return $this->redirectToRoute('main_vacances', [
                'fromHome' => 'ok',
                'activite' => $request->get('inputActivite'),
                'centre' => $request->get('inputcategorieCentre'),
                'age' => $this->valid_donnees($request->get('age')),
                'saison' => $request->get('saison'),
                'duree' => $request->get('duree')
            ]);
        }
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2],
                'acti' => $return[3],
                'centreNom'=> $return[4]
            ]);
        }
        return $this->render('main/index.html.twig', [
            'articles' => $articles,
            'sejours' => $sejours
        ]);
    }

    /**
     * @Route("/vacances", name="main_vacances")
     */
    public function vacances(Request                             $request,
                             SejoursRepository                   $sejoursRepository,
                             ActivitesRepository                 $activitesRepository,
                             CentresCategoriesRepository         $centresCategoriesRepository,
                             CentresRepository                   $centresRepository,

                             ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                             DureeSejourRepository               $dureeSejourRepository,
                             ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        $sejours = $sejoursRepository->findAll();

        if ($request->get('fromHome')) {
            $idDuree = $dureeSejourRepository->findOneBy(['name' => $request->get('duree')]);
            $sejours = $sejoursRepository->findByForm($request->get('inputActivite'),
                $request->get('inputcategorieCentre'),
                $this->valid_donnees($request->get('age')),
                $request->get('saison'),
                $idDuree
            );
        }

        if ($request->isMethod('POST')) {

            if ($request->get('duree')!=null){

                $idDuree = $dureeSejourRepository->findOneBy(['name' => $request->get('duree')]);
                $sejours = $sejoursRepository->findByForm($request->get('inputActivite'),
                    $request->get('inputcategorieCentre'),
                    $request->get('age'),
                    $request->get('saison'),
                    $idDuree->getId());
            }else{
                $sejours = $sejoursRepository->findByForm($request->get('inputActivite'),
                    $request->get('inputcategorieCentre'),
                    $request->get('age'),
                    $request->get('saison'
                    ));

            }


        }


        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2],
                'acti' => $return[3],
                'centreNom'=> $return[4]
            ]);
        }
        return $this->render('main/sejours.html.twig', [
            'sejours' => $sejours,
        ]);
    }

    /**
     * @Route("/vacance/{slug}", name="main_vacance_view")
     */
    public function vacancesView(Request                             $request,
                                                                     $slug,
                                 ActivitesRepository                 $activitesRepository,
                                 SejoursRepository                   $sejoursRepository,
                                 CentresRepository                   $centresRepository,

                                 CentresCategoriesRepository         $centresCategoriesRepository,
                                 ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                                 ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        $sejour = $sejoursRepository->findOneBy(['slug' => $slug]);
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/sejoursView.html.twig', [
            'sejour' => $sejour,
        ]);
    }

    /**
     * @Route("/sport/{slug}", name="main_sport_view")
     */
    public function sport(Request                             $request,
                                                              $slug,
                          SejoursRepository                   $sejoursRepository,
                          ActivitesRepository                 $activitesRepository,
                          CentresCategoriesRepository         $centresCategoriesRepository,
                          CentresRepository                   $centresRepository,

                          ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                          ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        $activite = $activitesRepository->findOneBy(['slug' => $slug]);
        $sejours = $sejoursRepository->findByActivite($activite->getId());
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/sportView.html.twig', [
            'activite' => $activite,
            'sejours' => $sejours
        ]);
    }

    /**
     * @Route("/sports/{categorie}", name="main_sports")
     */
    public
    function sports(Request                             $request, $categorie,
                    ActivitesRepository                 $activitesRepository,
                    CentresCategoriesRepository         $centresCategoriesRepository,
                    CentresRepository                   $centresRepository,

                    ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                    ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {

        $activites = $activitesRepository->findByCategorie($categorie);
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/sports.html.twig', [
            'activites' => $activites,
            'categorie' => $categorie
        ]);
    }

    /**
     * @Route("/actu", name="main_actu")
     */
    public
    function actu(Request                             $request,
                  ArticlesRepository                  $articlesRepository,
                  CentresCategoriesRepository         $centresCategoriesRepository,
                  ActivitesRepository                 $activitesRepository,
                  CentresRepository                   $centresRepository,

                  ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,

                  ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        $articles = $articlesRepository->findAll();
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository, $activiteCategorieRepository, $classeDecouverteCategorieRepository, $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/actu.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/actualite/{slug}", name="main_actu_view")
     */
    public
    function actualite(Request                             $request, $slug,
                       CentresCategoriesRepository         $centresCategoriesRepository,
                       ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                       ActiviteCategorieRepository         $activiteCategorieRepository,
                       ActivitesRepository                 $activitesRepository,
                       CentresRepository                   $centresRepository,

                       ArticlesRepository                  $articlesRepository): Response
    {
        $article = $articlesRepository->findOneBy(['slug' => $slug]);
        $articlesByCategorie = $articlesRepository->findSimilar($article->getCategorie()->getId());
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/article.html.twig', [
            'article' => $article,
            'articles' => $articlesByCategorie
        ]);
    }

    /**
     * @Route("/etablissements/{centre}", name="main_centres")
     */
    public
    function centres($centre, Request $request,
                     ActivitesRepository $activitesRepository,
                     CentresRepository $centresRepository,
                     CentresCategoriesRepository $centresCategoriesRepository,
                     ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                     ActiviteCategorieRepository $activiteCategorieRepository): Response
    {
        $centres = $centresRepository->findByCategorie($centre);
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/centres.html.twig', [
            'centres' => $centres,
            'categorie' => $centre
        ]);
    }

    /**
     * @Route("/etablissement{id}", name="main_centre")
     */
    public
    function centre($id, Request $request,
                    SejoursRepository $sejoursRepository,
                    CentresRepository $centresRepository,
                    ActivitesRepository $activitesRepository,
                    CentresCategoriesRepository $centresCategoriesRepository,
                    ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                    ActiviteCategorieRepository $activiteCategorieRepository): Response
    {

        $centre = $centresRepository->findAllOfOne($id);
        $sejoursDuCentre = $sejoursRepository->findAllByCentre($id);
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/centreView.html.twig', [
            'centre' => $centre,
            'sejours' => $sejoursDuCentre
        ]);
    }

    /**
     * @Route("/sessions/{categorie}", name="main_classes")
     */
    public
    function classes(Request                             $request,
                                                         $categorie,
                     ClasseDecouverteRepository          $classeDecouverteRepository,
                     CentresCategoriesRepository         $centresCategoriesRepository,
                     ActivitesRepository                 $activitesRepository,
                     CentresRepository                   $centresRepository,
                     ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                     ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($categorie == 'Tous') {
            $classes = $classeDecouverteRepository->findAll();
        } else {
            $classes = $classeDecouverteRepository->findByCategorie($categorie);
        }

        $categorieDeClasses = $classeDecouverteCategorieRepository->findAll();
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/classes.html.twig', [
            'classes' => $classes,
            'categories' => $categorieDeClasses
        ]);
    }

    /**
     * @Route("/session/{slug}", name="main_classe")
     */
    public
    function classe(Request                             $request, $slug,
                    ClasseDecouverteRepository          $classeDecouverteRepository,
                    CentresCategoriesRepository         $centresCategoriesRepository,
                    ActivitesRepository                 $activitesRepository,
                    CentresRepository                   $centresRepository,
                    ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                    ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        $classe = $classeDecouverteRepository->findOneBy(['slug' => $slug]);
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/classeView.html.twig', [
            'classe' => $classe,
        ]);
    }


//    **********************************************************************************

    /**
     * @Route("/apropos", name="main_about")
     */
    public
    function about(Request                             $request,
                   SejoursRepository                   $sejoursRepository,
                   CentresRepository                   $centresRepository,
                   ActivitesRepository                 $activitesRepository,
                   CentresCategoriesRepository         $centresCategoriesRepository,
                   ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                   ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {

        $nbsejour = $sejoursRepository->counter();
        $nbActivite = $activiteCategorieRepository->counter();
        $nbCentre = $centresRepository->counter();
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository, $activiteCategorieRepository, $classeDecouverteCategorieRepository, $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/about.html.twig', [
            'nbSejour' => $nbsejour,
            'nbActivite' => $nbActivite,
            'nbCentre' => $nbCentre
        ]);
    }

    /**
     * @Route("/ce", name="main_ce")
     */
    public
    function ce(Request                             $request,
                MailerInterface                     $mailer,
                CentresCategoriesRepository         $centresCategoriesRepository,
                ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                ActivitesRepository                 $activitesRepository,
                CentresRepository                   $centresRepository,
                ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository, $activiteCategorieRepository, $classeDecouverteCategorieRepository, $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }

        if ($request->isMethod('POST') && $request->get('consentement')) {
            $subject = $subject = 'Une nouvel demande de contact pour le Comité d\'entreprise, entreprise: ' . $this->valid_donnees($request->get('entreprise'));
            $emailContact = (new Email())
                ->from($this->valid_donnees($request->get('email')))
                ->to(self::EMAIL)
                ->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                ->text('Le client: ' . $this->valid_donnees($request->get('name')) . ', numéro: ' . $this->valid_donnees($request->get('tel')) . ', email: ' . $this->valid_donnees($request->get('email')) . ' a un message pour vous: ' . $this->valid_donnees($request->get('message')));
            try {
                $mailer->send($emailContact);
                $this->addFlash('success', 'Votre message a bien été envoyé');
                return $this->redirectToRoute('main_contact');
            } catch (ExceptionInterface $exception) {
                $this->addFlash('danger', 'l\'adresse email renseigné n\'est pas valable');
                return $this->redirectToRoute('main_contact');

            }
        }
        return $this->render('main/ce.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/cgv", name="main_cgv")
     */
    public
    function cgv(Request                             $request,
                 CentresCategoriesRepository         $centresCategoriesRepository,
                 ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                 ActivitesRepository                 $activitesRepository,
                 CentresRepository                   $centresRepository,
                 ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/cgv.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/contact", name="main_contact")
     */
    public
    function contact(Request                             $request,
                     SejoursRepository                   $sejoursRepository,
                     ClasseDecouverteRepository          $classeDecouverteRepository,
                     MailerInterface                     $mailer,
                     CentresCategoriesRepository         $centresCategoriesRepository,
                     CentresRepository                   $centresRepository,
                     ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                     ActivitesRepository                 $activitesRepository,
                     ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {

        $subject = 'nouvel demande de contact';
        if ($request->get('classe')) {
            $classe = $classeDecouverteRepository->find($this->valid_donnees($request->get('id')));
            $subject = 'Une nouvel demande de contact pour la classe decouverte:' . $classe->getTitre();
        }
        if ($request->get('sejour')) {
            $sejour = $sejoursRepository->find($this->valid_donnees($request->get('id')));
            $subject = 'Une nouvel demande de contact pour le séjour:' . $sejour->getTitre();
        }
        if ($request->isMethod('POST') && $this->valid_donnees($request->get('consentement'))) {

            $emailContact = (new Email())
                ->from($this->valid_donnees($request->get('email')))
                ->to(self::EMAIL)
                ->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                ->text('Le client: ' . $this->valid_donnees($request->get('name')) . ', numéro: ' . $this->valid_donnees($request->get('tel')) . ', email: ' . $this->valid_donnees($request->get('email')) . ' a un message pour vous: ' . $this->valid_donnees($request->get('message')));
            try {

                $mailer->send($emailContact);
                $this->addFlash('success', 'Votre message a bien été envoyé');
                return $this->redirectToRoute('main_contact');
            } catch (ExceptionInterface $exception) {
                $this->addFlash('danger', 'l\'adresse email renseigné n\'est pas valable');
                return $this->redirectToRoute('main_contact');


            }

        }
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/info", name="main_info")
     */
    public
    function infoPratique(Request                             $request,
                          CentresCategoriesRepository         $centresCategoriesRepository,
                          ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                          ActivitesRepository                 $activitesRepository,
                          CentresRepository                   $centresRepository,
                          ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/info.html.twig', []);
    }

    /**
     * @Route("/plus", name="main_plus")
     */
    public
    function plus(Request                             $request,
                  CentresCategoriesRepository         $centresCategoriesRepository,
                  ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                  ActivitesRepository                 $activitesRepository,
                  CentresRepository                   $centresRepository,
                  ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/plus.html.twig', []);
    }

    /**
     * @Route("/legals", name="main_legals")
     */
    public
    function legals(Request                             $request,
                    CentresCategoriesRepository         $centresCategoriesRepository,
                    ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                    ActivitesRepository                 $activitesRepository,
                    CentresRepository                   $centresRepository,
                    ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository, $activiteCategorieRepository, $classeDecouverteCategorieRepository, $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }
        return $this->render('main/legals.html.twig', []);
    }

    /**
     * @Route("/recrutement", name="main_recrutement", methods={"GET", "POST"})
     */
    public
    function recrutement(Request                             $request,
                         MailerInterface                     $mailer,
                         CentresCategoriesRepository         $centresCategoriesRepository,
                         ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                         ActivitesRepository                 $activitesRepository,
                         CentresRepository                   $centresRepository,
                         ActiviteCategorieRepository         $activiteCategorieRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $return = $this->ajax($centresCategoriesRepository,
                $activiteCategorieRepository,
                $classeDecouverteCategorieRepository,
                $activitesRepository, $centresRepository);
            return new JsonResponse([
                'lesClasses' => $return[0],
                'centres' => $return[1],
                'activite' => $return[2]
            ]);
        }

        if ($request->isMethod('POST') && $this->valid_donnees($request->get('consentement'))) {

            if ($request->files->get('cv') != null && $request->files->get('cv') != '') {


                $cv = $request->files->get('cv');
                $fichier1 = md5(uniqid()) . '.' . $cv->guessExtension();
                $cv->move(
                    $this->getParameter('files_directory'),
                    $fichier1
                );
                $partCv = new DataPart(fopen($this->getParameter('files_directory') .
                    '/' . $fichier1, 'r+'), 'cv de ' .
                    $this->valid_donnees($request->get('name')), 'application/pdf');
            }

            if ($request->files->get('lettre') != null && $request->files->get('lettre') != '') {
                $lettre = $request->files->get('lettre');
                $fichier2 = md5(uniqid()) . '.' . $lettre->guessExtension();
                $lettre->move(
                    $this->getParameter('files_directory'),
                    $fichier2
                );
                $partLettre = new DataPart(fopen($this->getParameter('files_directory') .
                    '/' . $fichier2, 'r+'), 'lettre de motivation ' .
                    $this->valid_donnees($request->get('name')), 'application/pdf');
            }
            $subject = 'une nouvelle demande pour un recrutement';
            $emailContact = (new Email())
                ->from($this->valid_donnees($request->get('email')))
                ->to('moishadow@gmail.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($subject);
            if ($partCv != null) {
                $emailContact->attachPart($partCv);
            }
            if ($partLettre != null) {
                $emailContact->attachPart($partLettre);
            }

            $emailContact->text('Monsieur ou Madame: ' .
                $this->valid_donnees($request->get('name')) . ' ' .
                $this->valid_donnees($request->get('prenom')) .

                ', email: ' . $this->valid_donnees($request->get('email')) .
                ' souhaite postuler en tant que: ' . $this->valid_donnees($request->get('poste')) .
                ' le message associé: ' . $this->valid_donnees($request->get('message')));
            try {
                if ($partCv != null) {
                    unlink($this->getParameter('files_directory') . '/' . $fichier1);
                }
                if ($partLettre != null) {
                    unlink($this->getParameter('files_directory') . '/' . $fichier2);
                }
                $mailer->send($emailContact);
                $this->addFlash('success', 'Votre message a bien été envoyé');
                return $this->redirectToRoute('main_recrutement');
            } catch (ExceptionInterface $exception) {
                $this->addFlash('danger', 'l\'adresse email renseigné n\'est pas valable');
                return $this->redirectToRoute('main_recrutement');

            }

        }

        return $this->render('main/recrutement.html.twig', []);
    }

    public
    function ajax(CentresCategoriesRepository         $centresCategoriesRepository,
                  ActiviteCategorieRepository         $activiteCategorieRepository,
                  ClasseDecouverteCategorieRepository $classeDecouverteCategorieRepository,
                  ActivitesRepository                 $activitesRepository,
                  CentresRepository                   $centresRepository)
    {
        $categorieCentre = $centresCategoriesRepository->findAll();
        $categorieActivite = $activiteCategorieRepository->findAll();
        $activitesARecuperer = $activitesRepository->findAll();
        $classesDecouvertes = $classeDecouverteCategorieRepository->findAll();
        $centreALl = $centresRepository->findAll();


        $centreT = [];
        $classes = [];
        $centre = [];
        $activites = [];
        $answer = [];
        foreach ($classesDecouvertes as $classe) {
            array_push($classes, $classe->getName());

        }
        array_push($answer, $classes);




        foreach ($categorieCentre as $cat) {
            array_push($centre, $cat->getName());

        }
        array_push($answer, $centre);
        $activite = [];
        foreach ($categorieActivite as $categorie) {
            array_push($activite, $categorie->getName());

        }
        array_push($answer, $activite);

        foreach ($activitesARecuperer as $acti) {
            array_push($activites, $acti->getName());

        }
        array_push($answer, $activites);

        foreach ($centreALl as $cent) {
            array_push($centreT, $cent->getName());

        }
        array_push($answer, $centreT);

        return $answer;
    }


    function valid_donnees($donnees)
    {
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }

}
