<?php

namespace CoralMedia\Component\Printing\Helper;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImagePlaceHolderHelper
 *
 * @package CoralMedia\Component\Printing\Helper
 */
class ImagePlaceHolderHelper
{
    /**
     * @param int $width Width in pixels
     * @param int $height Height in pixels
     * @return Response
     */
    public function getResponse($width = 400, $height = 400): Response
    {
        $img = ImageCreate($width, $height);
        $bg = imagecolorallocate($img, 128, 128, 128);
        ImageFill($img, 0, 0, $bg);
        ob_start();
        imagepng($img);
        $imageString = ob_get_clean();
        $headers= array(
            'Content-type'=>'image/png',
            'Pragma'=>'no-cache',
            'Cache-Control'=>'no-cache'
        );

        return new Response($imageString, Response::HTTP_OK, $headers);
    }
}