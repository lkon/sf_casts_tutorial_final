<?php

namespace App\Serializer\Normalizer;

use App\Entity\ImagePost;
use App\Service\PhotoUploaderManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ImagePostNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private $normalizer;
    private $uploaderManager;
    private $router;

    public function __construct(
        ObjectNormalizer $normalizer,
        PhotoUploaderManager $uploaderManager,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->normalizer = $normalizer;
        $this->uploaderManager = $uploaderManager;
        $this->router = $urlGenerator;
    }

    /**
     * @param ImagePost $imagePost
     */
    public function normalize($imagePost, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($imagePost, $format, $context);

        $data['url'] = $this->uploaderManager->getPublicPath($imagePost);

        // a custom, and therefore "poor" way of adding a link to myself
        // formats like JSON-LD (from API Platform) do this in a much
        // nicer and more standardized way
        $data['@id'] = $this->router->generate('get_image_post_item', [
            'id' => $imagePost->getId()
        ]);

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof ImagePost;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
