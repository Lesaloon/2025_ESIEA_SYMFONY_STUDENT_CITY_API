<?php
// src/Controller/Api/AdminPlaceApiController.php

namespace App\Controller\Api;

use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/admin/places')]
#[IsGranted('ROLE_ADMIN')]
class AdminPlaceApiController extends AbstractController
{
    #[Route('/{id}/validate', name: 'api_admin_place_validate', methods: ['POST'])]
    public function validate(Place $place, EntityManagerInterface $em): JsonResponse
    {
        if ($place->getStatut() === 'en attente') {
            $place->setStatut('validé');
            $em->flush();
            return $this->json(['success' => true, 'message' => 'Établissement validé avec succès']);
        }
        return $this->json(['success' => false, 'message' => 'Établissement déjà validé ou statut incorrect'], 400);
    }

    #[Route('/{id}/revoke', name: 'api_admin_place_revoke', methods: ['POST'])]
    public function revoke(Place $place, EntityManagerInterface $em): JsonResponse
    {
        if ($place->getStatut() === 'validé') {
            $place->setStatut('en attente');
            $em->flush();
            return $this->json(['success' => true, 'message' => 'Établissement remis en attente']);
        }
        return $this->json(['success' => false, 'message' => 'Établissement déjà en attente ou statut incorrect'], 400);
    }
}