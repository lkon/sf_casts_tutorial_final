<?php


namespace App\Service;


use Intervention\Image\Constraint;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

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
            ->make(__DIR__.'/../../assets/ponka/alien-profile.png');

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
}
