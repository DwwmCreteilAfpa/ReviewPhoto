<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhotoController extends AbstractController
{
    #[Route('/', name: 'photo.list')]
    public function list(): Response
    {
        $photo = new Photo();
        $photo->setTitle('Première photo');
        $photo->setPostAt(new \DateTimeImmutable());

//        $photos = [];
        $photos[] = $photo;

        return $this->render('photo/list.html.twig', [
            'photos' => $photos,
        ]);
    }
}

