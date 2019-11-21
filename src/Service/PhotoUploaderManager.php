<?php


namespace App\Service;


use App\Entity\ImagePost;
use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoUploaderManager
{
    private $filesystem;
    private $publicAssetBaseUrl;

    public function __construct(FilesystemInterface $photoFilesystem, string $publicAssetBaseUrl)
    {
        $this->filesystem = $photoFilesystem;
        $this->publicAssetBaseUrl = $publicAssetBaseUrl;
    }

    public function uploadImage(File $file): string
    {
        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }

        $newFilename = Urlizer::urlize(
                pathinfo($originalFilename, PATHINFO_FILENAME)
            ).'-'.uniqid().'.'.$file->guessExtension();

        $stream = fopen($file->getPathname(), 'r');
        $result = $this->filesystem->writeStream(
            $newFilename,
            $stream,
            [
                'visibility' => AdapterInterface::VISIBILITY_PUBLIC,
            ]
        );
        if ($result === false) {
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
        }
        if (is_resource($stream)) {
            fclose($stream);
        }
        return $newFilename;
    }

    public function deleteImage(string $filename):  void
    {
        sleep(3);

        $this->filesystem ->delete($filename);
    }

    public function getPublicPath(ImagePost $imagePost): string
    {
        return $this->publicAssetBaseUrl.'/'.$imagePost->getFilename();
    }
}
