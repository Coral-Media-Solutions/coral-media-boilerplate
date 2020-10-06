<?php

namespace CoralMedia\Bundle\DemoBundle\Controller;

use CoralMedia\Bundle\SecurityBundle\Controller\UserCrudController;
use CoralMedia\Bundle\SecurityBundle\Controller\UserProfileController;
use CoralMedia\Bundle\SecurityBundle\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DemoDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Coral Media Boilerplate Demo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class)
            ->setController(UserCrudController::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $crudUrlGenerator = $this->get(CrudUrlGenerator::class);
        $profileUrl = $crudUrlGenerator->build()
            ->setController(UserProfileController::class)
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($this->getUser()->getId())
            ->generateUrl();
        return parent::configureUserMenu($user)
            ->setName($user->getFirstName() . ' '. $user->getLastName())
            ->displayUserName(false)
            ->addMenuItems([
                MenuItem::linkToUrl('My Profile', 'fa fa-id-card', $profileUrl),
            ]);
    }
}
