<?php
// src/Controller/AdminReviewController.php

namespace App\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminReviewController extends AbstractController
{
    #[Route('/admin/reviews', name: 'admin_reviews')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(EntityManagerInterface $em): Response
    {
        $reviews = $em->getRepository(Review::class)->findAll();
        return $this->render('admin/reviews.html.twig', ['reviews' => $reviews]);
    }

    #[Route('/admin/reviews/{id}/approve', name: 'admin_review_approve', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function approve(int $id, EntityManagerInterface $em): Response
    {
        $review = $em->getRepository(Review::class)->find($id);
        if ($review) {
            $review->setStatut('approuvé');
            $em->flush();
            $this->addFlash('success', 'Avis approuvé.');
        }
        return $this->redirectToRoute('admin_reviews');
    }

    #[Route('/admin/reviews/{id}/reject', name: 'admin_review_reject', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function reject(int $id, EntityManagerInterface $em): Response
    {
        $review = $em->getRepository(Review::class)->find($id);
        if ($review) {
            $review->setStatut('refusé');
            $em->flush();
            $this->addFlash('warning', 'Avis refusé.');
        }
        return $this->redirectToRoute('admin_reviews');
    }

    #[Route('/admin/reviews/{id}', name: 'admin_review_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $review = $em->getRepository(Review::class)->find($id);
        if ($review) {
            $em->remove($review);
            $em->flush();
            $this->addFlash('danger', 'Avis supprimé.');
        }
        return $this->redirectToRoute('admin_reviews');
    }
}