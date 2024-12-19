<?php

namespace App\DataFixtures;

use App\Entity\Professeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfesseurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($j = 1; $j <= 10; $j++) {
            $professeur = new Professeur();
            $professeur->setNom('Professeur ' . $j)
                       ->setPrenom('Prenom ' . $j);
            $manager->persist($professeur);
        }

        $manager->flush();
    }
}
