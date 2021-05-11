<?php


namespace CoralMedia\Component\Api\MediaObject;


use ArrayObject;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class MediaObjectNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    protected $storage;
    protected $router;

    public function __construct(StorageInterface $storage, RouterInterface $router)
    {
        $this->router = $router;
        $this->storage = $storage;
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, ?string $format = null, array $context = [])
    {
        $context[MediaObjectInterface::ALREADY_CALLED] = true;

        $object->setContentUrl($this->storage->resolveUri($object, 'file'));

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[MediaObjectInterface::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof MediaObjectInterface;
    }
}