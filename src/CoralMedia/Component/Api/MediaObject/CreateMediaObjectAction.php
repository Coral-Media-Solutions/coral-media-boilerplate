<?php


namespace CoralMedia\Component\Api\MediaObject;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class CreateMediaObjectAction
{
    protected $uploadedFile;

    public function validate(Request $request): void
    {

        if (!$request->files->get('file')) {
            throw new BadRequestHttpException('"file" is required');
        }
    }
}