<?php


namespace CoralMedia\Bundle\PrintingBundle\Controller\Crud;


use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatch;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class PrintingBatchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PrintingBatch::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('reference'),
            AssociationField::new('pdfFile'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $fileUriPrefix = $this->getParameter('vich_uploader.mappings')['media_object']['uri_prefix'];
        $downloadPdfFileAction = Action::new(
            'downloadPdfFile', 'Download', 'fas fa-cloud-download-alt'
        )->linkToUrl(
            function (PrintingBatch $entity) use ($fileUriPrefix) {
                return '/'. $fileUriPrefix . '/' . $entity->getPdfFile()->getFilePath();
            }
        )->setHtmlAttributes(['target' => '_blank',]);

        return $actions
            ->disable(Action::NEW)
            ->add(Crud::PAGE_INDEX, $downloadPdfFileAction)
            ->add(Crud::PAGE_DETAIL, $downloadPdfFileAction);
    }
}