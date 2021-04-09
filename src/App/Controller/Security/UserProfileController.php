<?php


namespace App\Controller\Security;

use CoralMedia\Bundle\SecurityBundle\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserProfileController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function index(AdminContext $context): Response
    {
        return $this->redirect(
            $this->get(AdminUrlGenerator::class)
                ->setController(UserProfileController::class)
                ->setAction(Crud::PAGE_EDIT)
                ->setEntityId($this->getUser()->getId())
                ->generateUrl()
        );
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('plainPassword', 'Current Password')
                ->onlyOnForms()
                ->setRequired(true)
                ->setFormType(PasswordType::class),
            TextField::new('firstName'),
            TextField::new('lastName'),
            Field::new('imageFile', 'Profile Picture')
                ->setFormType(VichImageType::class)
                ->setTranslationParameters(['form.label.delete'=>'Delete'])->onlyOnForms(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
//            ->setEntityPermission('ROLE_USER')
            ->setPageTitle(Crud::PAGE_EDIT, '%entity_label_singular% Profile');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE, Action::INDEX)
            ->setPermission(Action::EDIT, 'ROLE_USER')
            ->setPermission(Action::DETAIL, 'ROLE_USER');
    }
}