<?php


namespace App\Service;


use App\Entity\ImagePost;
use Doctrine\ORM\EntityManagerInterface;
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
        $newImage = $this->imageManager->make(
            $this->photoFilesystem->readStream(
                $imagePost->getFilename()
            )
        );

        $newImage = $newImage->insert(
            file_get_contents(__DIR__.'/../../assets/ponka/alien-profile.png'),
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
