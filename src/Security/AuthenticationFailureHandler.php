<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($exception instanceof AccessDeniedException) {
            $this->addFlash('error', 'Vous devez avoir le rôle ROLE_USER pour accéder à cette application.');
        } else {
            $this->addFlash('error', 'Identifiants invalides.');
        }

        return new RedirectResponse('/login');
    }

    private function addFlash(string $type, string $message): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['_flash'][$type][] = $message;
    }
} 