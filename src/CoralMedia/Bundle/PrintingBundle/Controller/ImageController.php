<?php

namespace CoralMedia\Bundle\PrintingBundle\Controller;

use CoralMedia\Component\Printing\Helper\ImagePlaceHolderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/placeholder_30_40", name="printing_image_placeholder")
     * @param Request $request
     * @return Response
     */
    public function imgPlaceholder3040(Request $request): Response
    {
        $imgPlaceholderHelper = new ImagePlaceHolderHelper();

        $placeholder = $imgPlaceholderHelper->createPlaceHolder(3350, 4350, [255,255,255]);

        return $imgPlaceholderHelper->getResponse($placeholder);

    }
}
