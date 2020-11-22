<?php

namespace App\Serializer;

use App\Entity\EntityWithImage;
use App\Entity\EntityWithMediaAndImage;
use App\Entity\Media;
use ArrayObject;
use InvalidArgumentException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Serializer\SerializerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

/**
 * Class ImageUrlNormalizer
 * @package App\Serializer
 */
final class ImageUrlNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var DenormalizerInterface|NormalizerInterface
     */
    private $decorated;

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * ImageUrlNormalizer constructor.
     * @param NormalizerInterface $decorated
     * @param CacheManager $cacheManager
     * @param StorageInterface $storage
     */
    public function __construct(NormalizerInterface $decorated, CacheManager $cacheManager, StorageInterface $storage)
    {
        if (!$decorated instanceof DenormalizerInterface) {
            throw new InvalidArgumentException(sprintf('The decorated normalizer must implement the %s.', DenormalizerInterface::class));
        }

        $this->decorated = $decorated;
        $this->cacheManager = $cacheManager;
        $this->storage = $storage;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);
        if ($object instanceof Media) {
            $data['imageUrl'] = $this->generateImageUrl($object, 'imageFile', 'media_down_scale');
        } elseif ($object instanceof EntityWithImage) {
            $data['imageUrl'] = $this->generateImageUrl($object, 'imageFile', 'entity_with_image_down_scale');
        } elseif ($object instanceof EntityWithMediaAndImage) {
            $data['imageUrl'] = $this->generateImageUrl($object, 'imageFile', 'entity_with_media_and_image_down_scale');
        }

        return $data;
    }

    /**
     * @param $object
     * @param $imageFileFieldName
     * @param $filter
     * @return string|null
     */
    public function generateImageUrl($object, $imageFileFieldName, $filter): ?string
    {
        $originalImageUrl = $this->storage->resolveUri($object, $imageFileFieldName);
        if (null !== $originalImageUrl) {
            return $this->cacheManager->generateUrl($originalImageUrl, $filter);
        }

        return null;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return $this->decorated->supportsDenormalization($data, $type, $format);
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param string|null $format
     * @param array $context
     * @return array|object
     * @throws ExceptionInterface
     */
    public function denormalize($data, $class, string $format = null, array $context = [])
    {
        return $this->decorated->denormalize($data, $class, $format, $context);
    }

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }
}