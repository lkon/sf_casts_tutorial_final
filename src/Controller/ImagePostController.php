<?php

namespace App\Controller;

use App\Entity\ImagePost;
use App\Repository\ImagePostRepository;
use App\Service\PhotoUploaderManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImagePostController extends AbstractController
{
    /**
     * @Route(
     *     "/api/images",
     *     name="api_image_list",
     *     methods={"GET"}
     * )
     */
    public function list(ImagePostRepository $repository)
    {
        $posts = $repository->findAll();

        return $this->json([
            'items' => $posts,
        ]);
    }

    /**
     * @Route(
     *     "/api/images",
     *     name="api_image_create",
     *     methods={"POST"}
     * )
     */
    public function create(
        Request $request,
        ValidatorInterface $validator,
        PhotoUploaderManager $photoUploader,
        EntityManagerInterface $em
    )
    {
        /** @var UploadedFile $imageFile */
        $imageFile = $request->files->get('file');

        $violations = $validator->validate($imageFile, [
            new Image(),
            new NotBlank(),
        ]);

        if ($violations->count() > 0) {
            return $this->json($violations, 400);
        }

        $newFilename = $photoUploader->uploadImage($imageFile);

        $imagePost = new ImagePost();
        $imagePost
            ->setFilename($newFilename)
            ->setOriginalFilename($imageFile->getClientOriginalName());

        $em->persist($imagePost);
        $em->flush();

        //The HTTP 201 Created success status response code
        // indicates that the request has succeeded and has
        // led to the creation of a resource.
        return $this->json($imagePost, 201);
    }

    protected function json($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        // add the image:output group by default
        if (!isset($context['groups'])) {
            $context['groups'] = ['image:output'];
        }

        return parent::json($data, $status, $headers, $context);
    }
}
