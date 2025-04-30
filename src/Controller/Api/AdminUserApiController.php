<?php
// src/Controller/Api/AdminUserApiController.php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminUserApiController extends AbstractController
{
    #[Route('/api/admin/users/{id}/approve', name: 'api_admin_user_approve', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function approve(int $id, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) return $this->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        $user->setStatus('validé');
        $user->setRoles(['ROLE_USER']);
        $em->flush();
        return $this->json(['success' => true]);
    }

    #[Route('/api/admin/users/{id}/revoke', name: 'api_admin_user_revoke', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function revoke(int $id, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) return $this->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        $user->setStatus('en attente');
        $user->setRoles([]);
        $em->flush();
        return $this->json(['success' => true]);
    }
    // ... autres actions : reject, update role, revoke ...
}