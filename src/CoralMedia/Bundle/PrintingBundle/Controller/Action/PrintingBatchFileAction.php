<?php


namespace CoralMedia\Bundle\PrintingBundle\Controller\Action;


use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatchFile;
use CoralMedia\Component\Api\MediaObject\CreateMediaObjectAction;
use CoralMedia\Component\Api\MediaObject\MediaObjectInterface;
use Symfony\Component\HttpFoundation\Request;

class PrintingBatchFileAction extends CreateMediaObjectAction
{
    public function __invoke(Request $request): MediaObjectInterface
    {

        $this->validate($request);

        $this->uploadedFile = $request->files->get('file');

        $mediaObject = new PrintingBatchFile();
        $mediaObject->setFile($this->uploadedFile);

        return $mediaObject;
    }
}