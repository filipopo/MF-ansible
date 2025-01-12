<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController {
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response {
        return $this->render('admin/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void {
        throw new \LogicException();
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(Request $request): Response {
        $data = $request->getPayload()->all();

        if (isset($data['restart'])) {
            system('systemctl restart mobileforces');
        }

        if (isset($data['fastdl'])) {
            system('systemctl start mobileforces-fastdl');
        }
    
        if (isset($_POST['package'])) {
            system('systemctl start mobileforces-package');
        }

        return $this->render('admin/index.html.twig', $data);
    }
}
