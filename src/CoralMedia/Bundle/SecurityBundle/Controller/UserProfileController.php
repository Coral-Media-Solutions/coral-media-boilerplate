<?php


namespace CoralMedia\Bundle\SecurityBundle\Controller;


use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserProfileController extends UserCrudController
{
    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('plainPassword')
                ->onlyOnForms()
                ->setRequired(true)
                ->setFormType(PasswordType::class),
            TextField::new('firstName'),
            TextField::new('lastName'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_USER')
            ->setPageTitle(Crud::PAGE_EDIT, '%entity_label_singular% Profile');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE, Action::INDEX, Action::DETAIL)
            ->setPermission(Action::EDIT, 'ROLE_USER');
    }

}