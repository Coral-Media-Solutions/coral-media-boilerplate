<?php

namespace CoralMedia\Bundle\SecurityBundle\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security/login", name="coral_media_login")
     * @param AuthenticationUtils $authenticationUtils
     * @param KernelInterface $kernel
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, KernelInterface $kernel): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        try {
            if ($kernel->getBundle('CoralMediaWebDesktopBundle')) {
                return $this->render(
                    '@CoralMediaWebDesktop/security/login.html.twig',
                    ['last_username' => $lastUsername, 'error' => $error]
                );
            }
            if ($kernel->getBundle('EasyAdminBundle')) {
                return $this->_renderEasyAdminLoginForm($error, $lastUsername);
            }
        } catch (\InvalidArgumentException $e) {
            return $this->render(
                '@CoralMediaSecurity/security/login.html.twig',
                ['last_username' => $lastUsername, 'error' => $error]
            );
        }
    }

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

    /**
     * @Route("/security/logout", name="coral_media_logout")
     */
    public function logout()
    {
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    private function _renderEasyAdminLoginForm($error, $lastUsername)
    {
        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error' => $error,
            'last_username' => $lastUsername,

            // OPTIONAL parameters to customize the login form:

            // the translation_domain to use (define this option only if you are
            // rendering the login template in a regular Symfony controller; when
            // rendering it from an EasyAdmin Dashboard this is automatically set to
            // the same domain as the rest of the Dashboard)
            'translation_domain' => 'admin',

            // the title visible above the login form (define this option only if you are
            // rendering the login template in a regular Symfony controller; when rendering
            // it from an EasyAdmin Dashboard this is automatically set as the Dashboard title)
            'page_title' => 'Coral Media Login',

            // the string used to generate the CSRF token. If you don't define
            // this parameter, the login form won't include a CSRF token
            'csrf_token_intention' => 'authenticate',

            // the URL users are redirected to after the login (default: '/admin')
//            'target_path' => $this->generateUrl('admin_dashboard'),

            // the label displayed for the username form field (the |trans filter is applied to it)
            'username_label' => 'Your username',

            // the label displayed for the password form field (the |trans filter is applied to it)
            'password_label' => 'Your password',

            // the label displayed for the Sign In form button (the |trans filter is applied to it)
            'sign_in_label' => 'Log in',

            // the 'name' HTML attribute of the <input> used for the username field (default: '_username')
            'username_parameter' => 'email',

            // the 'name' HTML attribute of the <input> used for the password field (default: '_password')
            'password_parameter' => 'password',
        ]);
    }
}
