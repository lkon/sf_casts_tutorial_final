<?php


namespace App\Service;


use App\Entity\ImagePost;
use Doctrine\ORM\EntityManagerInterface;

class PhotoPonkaficator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function ponkafy(ImagePost $imagePost)
    {
        $imagePost->markAsPonkaAdded();

        $this->em->flush();
    }
}
