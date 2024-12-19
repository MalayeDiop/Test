<?php

namespace App\Controller;

use App\Repository\NiveauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NiveauController extends AbstractController
{
    #[Route('/api/niveaux', name: 'api_niveaux', methods: ['GET'])]
    public function getNiveaux(NiveauRepository $niveauRepository): JsonResponse
    {
        $niveaux = $niveauRepository->findAll();

        // Format des données pour la réponse
        $data = [];
        foreach ($niveaux as $niveau) {
            $data[] = [
                'id' => $niveau->getId(),
                'nom_niveau' => $niveau->getNomNiveau(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/niveaux', name: 'create_niveau', methods: ['POST'])]
    public function create(Request $request, NiveauRepository $niveauRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Créer un nouveau niveau
        $niveau = new Niveau();
        $niveau->setNomNiveau($data['nom_niveau']);
        
        $niveauRepository->save($niveau, true);

        // Retourner le niveau créé
        return $this->json([
            'id' => $niveau->getId(),
            'nom_niveau' => $niveau->getNomNiveau(),
        ], JsonResponse::HTTP_CREATED);
    }
}
