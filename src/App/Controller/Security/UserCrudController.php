<?php

namespace App\Controller\Security;

use CoralMedia\Bundle\SecurityBundle\Entity\User;
use CoralMedia\Component\Security\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\AdminContextFactory;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Vich\UploaderBundle\Form\Type\VichImageType;

use function parse_str;
use function parse_url;

class UserCrudController extends AbstractCrudController
{
    private $_userPasswordEncoder;
    private $_adminContextFactory;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder,
                                AdminContextFactory $adminContextFactory)
    {
        $this->_userPasswordEncoder = $userPasswordEncoder;
        $this->_adminContextFactory = $adminContextFactory;
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

    public function configureActions(Actions $actions): Actions
    {
        $export = Action::new('exportAction', 'actions.export')
            ->setIcon('fa fa-download')
            ->linkToCrudAction('exportAction')
            ->setCssClass('btn')
            ->createAsGlobalAction();

        return $actions->add(Crud::PAGE_INDEX, $export);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function exportAction(Request $request): Response
    {
        $context = $this->_getEasyAdminRefererContext($request);

        $searchDto = $this->_adminContextFactory->getSearchDto($request, $context->getCrud());
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());

        $result = $this->createIndexQueryBuilder(
            $searchDto, $context->getEntity(), $fields, $filters
        )
            ->getQuery()->getResult();

        $data = [];
        /**
         * @var $record User
         */
        foreach ($result as $record) {
            $data[] = [
                'email' => $record->getEmail(),
                'firstName' => $record->getFirstName(),
                'lastName' => $record->getLastName()
            ];
        }

        $filename = 'export_users_'.date_create()->format('d-m-y').'.csv';

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $response = new Response($serializer->encode($data, CsvEncoder::FORMAT));
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }

    private function _getEasyAdminRefererContext(Request $request)
    {
        parse_str(parse_url($request->query->get(EA::REFERRER))[EA::QUERY], $referrerQuery);
        $request->query->set(EA::FILTERS, $referrerQuery[EA::FILTERS]);
        return $request->attributes->get(EA::CONTEXT_REQUEST_ATTRIBUTE);
    }
}
