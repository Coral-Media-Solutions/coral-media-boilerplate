<?php


namespace CoralMedia\Bundle\SecurityBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RolesController extends AbstractController
{
    /**
     * @Route("/roles", name="coral_media_roles")
     */
    public function roles()
    {
        return new JsonResponse([
            'ROLE_SUPER_ADMIN',
            'ROLE_ADMIN',
            'ROLE_API',
            'ROLE_USER'
        ]);
    }
}