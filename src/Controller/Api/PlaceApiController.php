<?php

namespace App\Controller\Api;

use App\Entity\Place;
use App\Form\PlaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PlaceApiController extends AbstractController
{
    #[Route('/api/places', name: 'api_place_create', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['success' => false, 'errors' => $errors], 400);
        }

        $place->setStatut('En attente');
        $place->setUser($user);
        $place->setCreateAt(new \DateTimeImmutable());

        $em->persist($place);
        $em->flush();

        return $this->json([
            'success' => true,
            'message' => 'Établissement proposé avec succès. Il sera visible après validation.',
            'place' => [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'type' => $place->getType(),
                'adresse' => $place->getAdresse(),
                'description' => $place->getDescription(),
                'statut' => $place->getStatut(),
                'createAt' => $place->getCreateAt()->format('Y-m-d H:i:s'),
            ]
        ], 201);
    }

    #[Route('/api/places', name: 'api_places_list', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $places = $em->getRepository(Place::class)->findBy(['statut' => 'Validé']);
        $data = [];
        foreach ($places as $place) {
            $data[] = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'type' => $place->getType(),
                'adresse' => $place->getAdresse(),
                'description' => $place->getDescription(),
                'createAt' => $place->getCreateAt()?->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/places/{id}', name: 'api_place_show', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(EntityManagerInterface $em, int $id): JsonResponse
    {
        $place = $em->getRepository(Place::class)->find($id);
        if (!$place || $place->getStatut() !== 'Validé') {
            return $this->json(['error' => 'Établissement non trouvé ou non validé.'], 404);
        }
        return $this->json([
            'id' => $place->getId(),
            'name' => $place->getName(),
            'type' => $place->getType(),
            'adresse' => $place->getAdresse(),
            'description' => $place->getDescription(),
            'createAt' => $place->getCreateAt()?->format('Y-m-d H:i:s'),
        ]);
    }
} 