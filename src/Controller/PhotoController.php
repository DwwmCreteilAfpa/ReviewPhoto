<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhotoController extends AbstractController
{
    #[Route('/', name: 'photo.list')]
    public function list(PhotoRepository $photoRepository): Response
    {
        $photos = $photoRepository->findAll();

        return $this->render('photo/list.html.twig', [
            'photos' => $photos,
        ]);
    }

    #[Route('/photo/show/{id}', name : 'photo.show')]
    public function show(Photo $photo): Response
    {
        return $this->render('photo/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    #[Route('/photo/manage', name : 'photo.manage')]
    public function manage(): Response
    {
        $user = $this->getUser();
        $photos = $user->getPhotos();

        return $this->render('photo/manage.html.twig', [
            'photos' => $photos,
        ]);
    }

    #[Route('/photo/delete/{id}', name : 'photo.delete')]
    public function delete(Photo $photo): Response
    {
        return $this->redirectToRoute('photo.manage');
    }

}

