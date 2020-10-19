<?php


namespace CoralMedia\Bundle\ApiBundle\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security/api/token")
     * @param Request $request
     * @param JWTTokenManagerInterface $jwtTokenManager
     * @return JsonResponse|RedirectResponse
     */
    public function renewJwtToken(Request $request, JWTTokenManagerInterface $jwtTokenManager)
    {
        if ($this->getUser()) {
            $apiToken = $jwtTokenManager->create($this->getUser());
            $request->getSession()->set(
                'Bearer', $apiToken
            );

            return new JsonResponse(['token' => $apiToken]);
        }
        return $this->redirectToRoute("coral_media_login");
    }
}