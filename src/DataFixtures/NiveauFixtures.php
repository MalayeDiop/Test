<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NiveauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $niveaux = [];
        for ($j = 1; $j <= 3; $j++) {
            $niveau = new Niveau();
            $niveau->setNomNiveau('Niveau ' . $j);
            $manager->persist($niveau);
            $niveaux[] = $niveau;
        }

        for ($i = 1; $i <= 10; $i++) {
            $classe = new Classe();
            $classe->setNomClasse('Classe ' . $i)
                   ->setNiveau($niveaux[rand(0, count($niveaux) - 1)]);

            $manager->persist($classe);
        }

        $manager->flush();
    }
}
