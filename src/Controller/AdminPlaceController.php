<?php
// src/Controller/AdminPlaceController.php

namespace App\Controller;

use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminPlaceController extends AbstractController
{
    #[Route('/admin/places', name: 'admin_places')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(EntityManagerInterface $em): Response
    {
        $places = $em->getRepository(Place::class)->findBy(['statut' => 'En attente']);
        return $this->render('admin/places.html.twig', ['places' => $places]);
    }
}