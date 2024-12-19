<?php

namespace App\DataFixtures;
use App\Entity\Professeur;
use App\Entity\Cours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $professeurs = [];
        for ($j = 1; $j <= 3; $j++) {
            $professeur = new Professeur();
            $professeur->setNom('Professeur ' . $j)
                       ->setPrenom('Prenom ' . $j);
            $manager->persist($professeur);
            $professeurs[] = $professeur;
        }
        for ($i = 1; $i <= 10; $i++) {
            $cours = new Cours();
            $cours->setNomCours('Cours ' . $i)
                  ->setProf($professeurs[rand(0, count($professeurs) - 1)]);

            $manager->persist($cours);
        }
        $manager->flush();
    }
}
