<?php


namespace CoralMedia\Bundle\PrintingBundle\Controller\Crud;


use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatchFile;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class PrintingBatchFileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PrintingBatchFile::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $fileUriPrefix = $this->getParameter('vich_uploader.mappings')['media_object']['uri_prefix'];
        $downloadPdfFileAction = Action::new(
            'downloadPdfFile', 'Download', 'fas fa-cloud-download-alt'
        )->linkToUrl(
                function (PrintingBatchFile $entity) use ($fileUriPrefix) {
                    return '/'. $fileUriPrefix . '/' . $entity->getFilePath();
                }
        )->setHtmlAttributes(['target' => '_blank',]);

        return $actions
            ->disable(Action::NEW, Action::DELETE, Action::EDIT)
            ->add(Crud::PAGE_INDEX, $downloadPdfFileAction)
            ->add(Crud::PAGE_DETAIL, $downloadPdfFileAction);
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('filePath')->hideOnForm(),
        ];
    }


}