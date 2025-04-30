<?php
// src/Controller/Api/AdminReviewApiController.php

namespace App\Controller\Api;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminReviewApiController extends AbstractController
{
    #[Route('/api/admin/reviews/{id}', name: 'api_admin_review_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $review = $em->getRepository(Review::class)->find($id);
        if (!$review) return $this->json(['success' => false, 'message' => 'Avis non trouvé'], 404);
        $em->remove($review);
        $em->flush();
        return $this->json(['success' => true]);
    }

    #[Route('/api/admin/reviews/{id}/approve', name: 'api_admin_review_approve', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function approve(int $id, EntityManagerInterface $em): JsonResponse
    {
        $review = $em->getRepository(Review::class)->find($id);
        if (!$review) return $this->json(['success' => false, 'message' => 'Avis non trouvé'], 404);
        $review->setStatut('approuvé');
        $em->flush();
        return $this->json(['success' => true, 'message' => 'Avis approuvé']);
    }

    #[Route('/api/admin/reviews/{id}/reject', name: 'api_admin_review_reject', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function reject(int $id, EntityManagerInterface $em): JsonResponse
    {
        $review = $em->getRepository(Review::class)->find($id);
        if (!$review) return $this->json(['success' => false, 'message' => 'Avis non trouvé'], 404);
        $review->setStatut('refusé');
        $em->flush();
        return $this->json(['success' => true, 'message' => 'Avis refusé']);
    }
}