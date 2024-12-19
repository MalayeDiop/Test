<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(CoursRepository $coursRepository): JsonResponse
    {
        $cours = $coursRepository->findAll();

        $data = [];
        foreach ($cours as $cour) {
            $prof = $cour->getProf();
            $data[] = [
                'id' => $cour->getId(),
                'nom_cours' => $cour->getNomCours(),
                'professeur' => $prof ? $prof->getNom() : 'Professeur non attribué', // Nom du professeur
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/cours', name: 'api_cours', methods: ['GET'])]
    public function getCours(CoursRepository $coursRepository): JsonResponse
    {
        $cours = $coursRepository->findAll();

        $data = [];
        foreach ($cours as $cour) {
            $data[] = [
                'id' => $cour->getId(),
                'nom_cours' => $cour->getNomCours(),
                'prof' => $cour->getProf()->getNom(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/cours', name: 'api_add_cours', methods: ['POST'])]
    public function create(Request $request, CoursRepository $coursRepository, ProfesseurRepository $professeurRepository, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['nom_cours']) || empty($data['prof_id'])) {
            return $this->json(['error' => 'Le nom du cours et l\'ID du professeur sont nécessaires.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $professeur = $professeurRepository->find($data['prof_id']);
        if (!$professeur) {
            return $this->json(['error' => 'Professeur non trouvé.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $cours = new Cours();
        $cours->setNomCours($data['nom_cours']);
        $cours->setProf($professeur);

        $errors = $validator->validate($cours);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return $this->json(['error' => $errorsString], JsonResponse::HTTP_BAD_REQUEST);
        }

        $coursRepository->save($cours, true);

        return $this->json([
            'id' => $cours->getId(),
            'nom_cours' => $cours->getNomCours(),
            'prof' => $cours->getProf()->getNom(),
        ], JsonResponse::HTTP_CREATED);
    }
}
