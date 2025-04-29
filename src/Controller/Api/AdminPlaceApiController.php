<?php
// src/Controller/Api/AdminPlaceApiController.php

namespace App\Controller\Api;

use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminPlaceApiController extends AbstractController
{
    #[Route('/api/admin/places/{id}/approve', name: 'api_admin_place_approve', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function approve(int $id, EntityManagerInterface $em): JsonResponse
    {
        $place = $em->getRepository(Place::class)->find($id);
        if (!$place) return $this->json(['success' => false, 'message' => 'Établissement non trouvé'], 404);
        $place->setStatut('Validé');
        $em->flush();
        return $this->json(['success' => true]);
    }
    // ... action reject ...
}