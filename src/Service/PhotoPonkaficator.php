<?php


namespace App\Service;


use App\Entity\ImagePost;
use Doctrine\ORM\EntityManagerInterface;
use Intervention\Image\Constraint;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use League\Flysystem\FilesystemInterface;

class PhotoPonkaficator
{
    private $em;
    private $imageManager;
    private $photoFilesystem;

    public function __construct(
        EntityManagerInterface $em,
        ImageManager $imageManager,
        FilesystemInterface $photoFilesystem
    )
    {
        $this->em = $em;
        $this->imageManager = $imageManager;
        $this->photoFilesystem = $photoFilesystem;
    }

    public function ponkafy(ImagePost $imagePost)
    {
        /** @var Image $newImage */
        $newImage = $this->imageManager
            ->make(
                $this->photoFilesystem->readStream(
                    $imagePost->getFilename()
                )
            );

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
            50, 50
        );

        $this->photoFilesystem->update(
            $imagePost->getFilename(),
            $newImage->encode()
        );

        $imagePost->markAsPonkaAdded();
        sleep(2);

        $this->em->flush();
    }
}
