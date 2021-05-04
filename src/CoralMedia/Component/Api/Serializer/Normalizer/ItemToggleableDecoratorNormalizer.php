<?php

namespace CoralMedia\Component\Api\Serializer\Normalizer;

use CoralMedia\Component\Resource\Model\ToggleableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ItemToggleableDecoratorNormalizer implements
    NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        if (!$decorated instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException(
                sprintf('The decorated normalizer must implement the %s.', DenormalizerInterface::class));
        }

        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, $format = null, array $context = [])
    {
        return $this->decorated->normalize($object, $format, $context);
    }

    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $this->decorated->supportsDenormalization($data, $type, $format) &&
            is_subclass_of($type, ToggleableInterface::class);
    }

    public function denormalize($data, $type, $format = null, array $context = [])
    {
        if (is_array($data) && isset($data[ToggleableInterface::FIELD_NAME])) {
            $data[ToggleableInterface::FIELD_NAME] =
                ($data[ToggleableInterface::FIELD_NAME]=="false" || $data[ToggleableInterface::FIELD_NAME]=="0")?
                    false:true;
        }
        return $this->decorated->denormalize($data, $type, $format, $context);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        if($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}