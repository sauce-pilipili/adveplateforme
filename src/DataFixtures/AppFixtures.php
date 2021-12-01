<?php

namespace App\DataFixtures;

use App\Entity\ActiviteCategorie;
use App\Entity\Activites;
use App\Entity\ArticleCategories;
use App\Entity\Articles;
use App\Entity\Centres;
use App\Entity\CentresCategories;
use App\Entity\ClasseDecouverte;
use App\Entity\ClasseDecouverteCategorie;
use App\Entity\DureeSejour;
use App\Entity\Saisons;
use App\Entity\Sejours;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('moishadow@gmail.com');
        $user->setPassword('$2y$13$374klUfKu4rr88oHrqGX7umYRcWmrtqpnNLeRbam.fZmfxRsXfeRe');
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@admin.fr');
        $user->setPassword('$2y$13$374klUfKu4rr88oHrqGX7umYRcWmrtqpnNLeRbam.fZmfxRsXfeRe');
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);


        $imagesAPoster = [
            '5e0df0095ac4bfce54facfaf8e088b37.jpg',
            '6adcb5836cb6b7b9abcd5ba7d983e702.jpg',
            '6ea59506b23f465286ebdbd589643fe7.jpg',
            '7cc4413f068394809081d698f152ce4d.jpg',
            '9b55a3bb410d073bddb7ba34fa3ec957.jpg',
            '18ff5476d7e055f2991d4a5328d9b8f2.jpg',
            '19e404fd5dec370ec300cc41531410cc.jpg',
        ];


        $categorieArticle = array();
        for ($i = 0; $i < 4; $i++) {
            $categorieArticle[$i] = new ArticleCategories();
            $categorieArticle[$i]->setName($faker->domainWord);
            $manager->persist($categorieArticle[$i]);
        }
        $categorieclasse = array();
        for ($i = 0; $i < 4; $i++) {
            $categorieclasse[$i] = new ClasseDecouverteCategorie();
            $categorieclasse[$i]->setName($faker->domainWord);
            $manager->persist($categorieclasse[$i]);
        }
        $categorieCentre = array();
        for ($i = 0; $i < 4; $i++) {
            $categorieCentre[$i] = new CentresCategories();
            $categorieCentre[$i]->setName($faker->domainWord);
            $manager->persist($categorieCentre[$i]);
        }
        $categorieactivite = array();
        for ($i = 0; $i < 4; $i++) {
            $categorieactivite[$i] = new ActiviteCategorie();
            $categorieactivite[$i]->setName($faker->domainWord);
            $manager->persist($categorieactivite[$i]);
        }

        // nouvelle boucle pour créer des articles
        $articles = array();
        for ($i = 0; $i < 50; $i++) {
            $articles[$i] = new Articles();
            $articles[$i]->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $articles[$i]->setCreatedDate(new \DateTime('now'));
            $articles[$i]->setMetaDescription($faker->text(20));
            $articles[$i]->setCategorie($categorieArticle[$faker->numberBetween(0, 3)]);
            $articles[$i]->setContent('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $articles[$i]->setImageEnAvant($imagesAPoster[$faker->numberBetween(0,6)]);
            $manager->persist($articles[$i]);
        }

        $centres = array();
        for ($i = 0; $i < 45; $i++) {
            $centres[$i] = new Centres();
            $centres[$i]->setCategorieCentre($categorieCentre[$faker->numberBetween(0, 3)]);
            $centres[$i]->setName($faker->sentence($nbWords = 3, $variableNbWords = false));
            $centres[$i]->setMetaDescription($faker->text(20));
            $centres[$i]->setDescription('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $centres[$i]->setLocalisation($faker->city);
            $centres[$i]->setAgeMin($faker->numberBetween(3, 8));
            $centres[$i]->setAgeMax($faker->numberBetween(9, 17));
            $centres[$i]->setPhotoCadre($imagesAPoster[$faker->numberBetween(0,6)]);
            $centres[$i]->setPhotoEncadrement($imagesAPoster[$faker->numberBetween(0,6)]);
            $centres[$i]->setPhotoEnAvant($imagesAPoster[$faker->numberBetween(0,6)]);
            $centres[$i]->setLegendePhotoCadre($faker->sentence(5));
            $centres[$i]->setLegendePhotoEnAvant($faker->sentence(4));
            $centres[$i]->setLegendePhotoEncadrement($faker->sentence(5));
            $centres[$i]->setCadreDeVie('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $centres[$i]->setEncadrement('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $centres[$i]->setCentrePlus('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $manager->persist($centres[$i]);
        }

        $activite = array();
        for ($i = 0; $i < 36; $i++) {
            $activite[$i] = new Activites();
            $activite[$i]->setCategorie($categorieactivite[$faker->numberBetween(0, 3)]);
            $activite[$i]->setName($faker->sentence($nbWords = 1, $variableNbWords = false));
            $activite[$i]->setMetaDescription($faker->text(20));
            $activite[$i]->setDescription('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $activite[$i]->setHistoire('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $activite[$i]->setDiscipline('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $activite[$i]->setEquipement('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $activite[$i]->setAptitudes('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $activite[$i]->setCitation($faker->sentence(6));
            $activite[$i]->setPhotoEnAvant($imagesAPoster[$faker->numberBetween(0,6)]);
            $activite[$i]->setPhotoDiscipline($imagesAPoster[$faker->numberBetween(0,6)]);
            $activite[$i]->setPhotoHistoire($imagesAPoster[$faker->numberBetween(0,6)]);
            $activite[$i]->setLegendeEnAvant($faker->sentence(5));
            $activite[$i]->setLegendeHistoire($faker->sentence(5));
            $activite[$i]->setLegendePhotoDiscipline($faker->sentence(5));
            $activite[$i]->setCategorie($categorieactivite[$faker->numberBetween(0, 3)]);
            $manager->persist($activite[$i]);
        }

        $sai = ['printemps', 'ete', 'automne', 'hiver'];
        $saisonFinale = [];
        for ($o = 0; $o < 4; $o++) {
            $saisonFinale[$o] = new Saisons();
            $saisonFinale[$o]->setName($sai[$o]);
            $manager->persist($saisonFinale[$o]);
        }

        $dateSejour = ['7jours', '12jours', '19jours'];
        $dateFinale = [];
        for ($i = 0; $i < 3; $i++) {
            $dateFinale[$i] = new DureeSejour();
            $dateFinale[$i]->setName($dateSejour[$i]);
            $manager->persist($dateFinale[$i]);
        }


        $sejour = array();
        for ($i = 0; $i < 350; $i++) {
            $sejour[$i] = new Sejours();
            $sejour[$i]->setActivite($activite[$faker->numberBetween(0, 35)]);
            $sejour[$i]->setCentre($centres[$faker->numberBetween(0, 44)]);
            $sejour[$i]->setTitre($faker->sentence(4));
            $sejour[$i]->setMetaDescription($faker->sentence[5]);
            $sejour[$i]->setIntroduction('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setAgeMin($faker->numberBetween(3, 6));
            $sejour[$i]->setAgeMax($faker->numberBetween(8, 15));
            $sejour[$i]->setPrixMin($faker->numberBetween(800, 1523));
            $sejour[$i]->setCadreDeVie('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setEncadrement('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setPlusDuSejour('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setIndispensables('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setActivitesDominantes('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setActivitesAnnexes('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $sejour[$i]->setPhotoEnAvant($imagesAPoster[$faker->numberBetween(0,6)]);
            $sejour[$i]->setLegendePhotoEnAvant($faker->sentence(6));
            $sejour[$i]->setPhotoCadre($imagesAPoster[$faker->numberBetween(0,6)]);
            $sejour[$i]->setLegendePhotoCadre($faker->sentence(6));
            $sejour[$i]->setPhotoEncadrement($imagesAPoster[$faker->numberBetween(0,6)]);
            $sejour[$i]->setLegendePhotoEncadrement($faker->sentence(6));
            $sejour[$i]->setSaisons($saisonFinale[$faker->numberBetween(0, 3)]);
            $sejour[$i]->setDateSejour('du 1 au 14 aout \n du 05 au 21 mars');

            $true = $faker->boolean;
            if ($true) {
                $sejour[$i]->addDureeSejour($dateFinale[0]);
            }
            $truefirst = $faker->boolean;
            if ($truefirst) {
                $sejour[$i]->addDureeSejour($dateFinale[1]);
            }
            $truesecond = $faker->boolean;
            if ($truesecond) {
                $sejour[$i]->addDureeSejour($dateFinale[2]);
            }

            if (!$true && !$truefirst && !$truesecond) {
                $sejour[$i]->addDureeSejour($dateFinale[0]);
            }


            $manager->persist($sejour[$i]);

        }

        $classeDec = array();
        for ($i = 0; $i < 36; $i++) {
            $classeDec[$i] = new ClasseDecouverte();
//            $classeDec[$i]->setCentre($centres[$i % 3]);
            $classeDec[$i]->setTitre($faker->sentence(4));
            $classeDec[$i]->setMetaDescription($faker->sentence[5]);
            $classeDec[$i]->setIntroduction('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $classeDec[$i]->setPresentation('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $classeDec[$i]->setEncadrement('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $classeDec[$i]->setHebergement('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $classeDec[$i]->setDecouverte('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $classeDec[$i]->setAnimation('
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem 
Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like read
able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum
&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (i
njected humour and the like).</p>');
            $classeDec[$i]->setPhotoEnAvant($imagesAPoster[$faker->numberBetween(0,6)]);
            $classeDec[$i]->setLegendePhotoEnAvant($faker->sentence(6));
            $classeDec[$i]->setPhotoClasse($imagesAPoster[$faker->numberBetween(0,6)]);
            $classeDec[$i]->setLegendePhotoClasse($faker->sentence(6));
            $classeDec[$i]->setCategorie($categorieclasse[$i % 3]);
            $manager->persist($classeDec[$i]);
        }


        $manager->flush();
    }
}
