<?php


namespace App\Service;


use Intervention\Image\Constraint;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Symfony\Component\Finder\Finder;

class PhotoPonkaficator
{
    private $imageManager;

    public function __construct(
        ImageManager $imageManager
    )
    {
        $this->imageManager = $imageManager;
    }

    public function ponkafy(string $imageContents): string
    {
        /** @var Image $newImage */
        $newImage = $this->imageManager
            ->make($imageContents);

        $ponkaMark = $this->imageManager
            ->make($this->getRandomPonkaFilename());

        $ponkaMarkWidth = $newImage->width() * .2;
        $ponkaMarkHeight = $newImage->height() * .4;

        $ponkaMark->resize($ponkaMarkWidth, $ponkaMarkHeight, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $newImage = $newImage->insert(
            $ponkaMark,
            'bottom-left',
            (int)($newImage->width() * .05),
            (int)($newImage->height() * .05)
        );

        sleep(2);

        return (string)$newImage->encode();
    }

    private function getRandomPonkaFilename(): string
    {
        $finder = new Finder();

        $finder
            ->in(__DIR__.'/../../assets/ponka')
            ->files();

        $ponkaFiles = iterator_to_array($finder->getIterator());

        return array_rand($ponkaFiles);
    }
}
