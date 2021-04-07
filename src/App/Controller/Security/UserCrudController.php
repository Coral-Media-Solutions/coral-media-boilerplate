<?php

namespace App\Controller\Security;

use CoralMedia\Bundle\SecurityBundle\Entity\User;
use CoralMedia\Component\EasyCorp\Field\VichImageField;
use CoralMedia\Component\Security\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
                        UserInterface::ROLE_SUPERADMIN => UserInterface::ROLE_SUPERADMIN,
                        UserInterface::ROLE_ADMIN => UserInterface::ROLE_ADMIN,
                        UserInterface::ROLE_API => UserInterface::ROLE_API,
                        UserInterface::ROLE_USER => UserInterface::ROLE_USER
                    ]
                )
                ->allowMultipleChoices(),

            ImageField::new('image', 'Profile Picture')
                ->setUploadDir(
                    'public/' .
                    $this->getParameter('vich_uploader.mappings')['users']['uri_prefix']
                )
//                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setBasePath(
                    $this->getParameter('vich_uploader.mappings')['users']['uri_prefix']
                )->onlyOnIndex(),

            Field::new('imageFile', 'Profile Picture')
                ->setFormType(VichImageType::class)
                ->setTranslationParameters(['form.label.delete'=>'Delete'])->onlyOnForms(),

            DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex(),
            BooleanField::new('enabled'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('enabled')
            ->add('updatedAt')
            ->add('createdAt');
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPassword(
            $this->_userPasswordEncoder->encodePassword($entityInstance, $entityInstance->getPlainPassword())
        );
        parent::persistEntity($entityManager, $entityInstance);
    }
}
