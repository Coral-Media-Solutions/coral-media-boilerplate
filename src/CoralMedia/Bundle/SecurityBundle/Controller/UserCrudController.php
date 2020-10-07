<?php

namespace CoralMedia\Bundle\SecurityBundle\Controller;

use CoralMedia\Bundle\SecurityBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCrudController extends AbstractCrudController
{
    private $_userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->_userPasswordEncoder = $userPasswordEncoder;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('plainPassword')
                ->onlyOnForms()
                ->setRequired(true)
                ->setFormType(PasswordType::class),
            TextField::new('firstName'),
            TextField::new('lastName'),
            ChoiceField::new('roles')
                ->setChoices(
                    [
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_API' => 'ROLE_API',
                        'ROLE_USER' => 'ROLE_USER'
                    ]
                )
                ->allowMultipleChoices(),
        ];
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPassword(
            $this->_userPasswordEncoder->encodePassword($entityInstance, $entityInstance->getPlainPassword())
        );
        parent::persistEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }
}