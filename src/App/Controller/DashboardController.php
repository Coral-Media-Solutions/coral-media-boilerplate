<?php

namespace App\Controller;

use App\Controller\Printing\PrinterCrudController;
use App\Controller\Product\ProductCategoryCrudController;
use App\Controller\Product\ProductCrudController;
use App\Controller\Security\UserCrudController;
use App\Controller\Security\UserProfileController;
use CoralMedia\Bundle\PrintingBundle\Controller\Crud\PrintingBatchCrudController;
use CoralMedia\Bundle\PrintingBundle\Controller\Crud\PrintingBatchFileCrudController;
use CoralMedia\Bundle\PrintingBundle\Entity\Printer;
use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatch;
use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatchFile;
use CoralMedia\Bundle\ProductBundle\Entity\Product;
use CoralMedia\Bundle\ProductBundle\Entity\ProductCategory;
use CoralMedia\Bundle\SecurityBundle\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/", name="main_dashboard")
     */
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('coral_media_login');
        }
//                return parent::index();
        return $this->redirect(
            $this->get(AdminUrlGenerator::class)
                ->setController(UserProfileController::class)
                ->setAction(Crud::PAGE_EDIT)
                ->setEntityId($this->getUser()->getId())
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Order Management System');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fas fa-home');
        yield MenuItem::subMenu('Products', 'fas fa-boxes')->setSubItems(
            [
                MenuItem::linkToCrud('Catalog', 'fas fa-clipboard-list', Product::class)
                    ->setController(ProductCrudController::class),
                MenuItem::linkToCrud('Categories', 'fas fa-tags', ProductCategory::class)
                    ->setController(ProductCategoryCrudController::class),
            ]
        );

        yield MenuItem::subMenu('Inventory', 'fas fa-warehouse')->setSubItems(
            [

            ]
        );

        yield MenuItem::subMenu('Printing', 'fas fa-print')->setSubItems(
            [
                MenuItem::linkToCrud('Batches', 'fas fa-archive', PrintingBatch::class)
                    ->setController(PrintingBatchCrudController::class),
                MenuItem::linkToCrud('Batch Files', 'fas fa-file-pdf', PrintingBatchFile::class)
                    ->setController(PrintingBatchFileCrudController::class)
            ]
        );

        yield MenuItem::subMenu('Reports', 'fas fa-chart-line')->setSubItems(
            [

            ]
        );

        yield MenuItem::subMenu('Settings', 'fas fa-cogs')->setSubItems(
            [
                MenuItem::linkToCrud('Users', 'fas fa-users', User::class)
                    ->setController(UserCrudController::class),
                MenuItem::linkToCrud('Printers', 'fas fa-print', Printer::class)
                    ->setController(PrinterCrudController::class),
            ]
        );

        yield MenuItem::section('Support');
        yield MenuItem::subMenu('Help', 'fas fa-life-ring')->setSubItems(
            [
                MenuItem::linkToRoute('PDF Support', 'fas fa-file-pdf', 'support_help_pdf'),
            ]
        );
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        /**
         * @var $user User
         */
        $profileUrl = $this->get(AdminUrlGenerator::class)
            ->setController(UserProfileController::class)
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($this->getUser()->getId())
            ->generateUrl();

        return parent::configureUserMenu($user)
            ->setAvatarUrl(
                $this->getParameter('vich_uploader.mappings')['users']['uri_prefix']. '/' .
                $user->getImage()
            )
            ->displayUserAvatar(true)
            ->setName($user->getFirstName() . ' '. $user->getLastName())
            ->displayUserName(true)
            ->addMenuItems([
                MenuItem::linkToUrl('My Profile', 'fa fa-id-card', $profileUrl),
            ]);
    }
}
