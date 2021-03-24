<?php


namespace CoralMedia\Component\Api\Serializer\Normalizer;


use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;

class JsonLdToggleableDecoratorNormalizer  extends ItemToggleableDecoratorNormalizer
    implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{

}