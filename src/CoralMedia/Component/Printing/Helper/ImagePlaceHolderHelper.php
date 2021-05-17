<?php

namespace CoralMedia\Component\Printing\Helper;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImagePlaceHolderHelper
 *
 * @package CoralMedia\Component\Printing\Helper
 */
class ImagePlaceHolderHelper
{
    /**
     * @param $imageString
     * @param $format
     * @return Response
     */
    public function getResponse($imageString, $format): Response
    {

        $headers = array(
            'Content-type'=>'image/' . $format,
            'Pragma'=>'no-cache',
            'Cache-Control'=>'no-cache'
        );

        return new Response(
            $imageString, Response::HTTP_OK, $headers
        );
    }

    /**
     * @param int $width
     * @param int $height
     * @param int[] $background
     * @param string $format
     * @return false|string
     */
    public function createPlaceHolder($width = 400, $height = 400, $background = [128, 128, 128], $format = 'png')
    {
        $img = ImageCreate($width, $height);
        list($red, $green, $blue) = $background;
        $bg = imagecolorallocate($img, $red, $green, $blue);
        ImageFill($img, 0, 0, $bg);
        ob_start();
        if ($format === 'png') {
            imagepng($img);
        } elseif ($format === 'jpg') {
            imagejpeg($img);
        } else {
            throw new InvalidArgumentException(
                'Filetype not supported. Valid formats are \'jpg\' and \'png\'.'
            );
        }

        return ob_get_clean();
    }
}