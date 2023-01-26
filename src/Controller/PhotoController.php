<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\Photo\NewPhotoType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function delete(Photo $photo, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($photo);
        $entityManager->flush();

        return $this->redirectToRoute('photo.manage');
    }

    #[Route('/photo/new', name : 'photo.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photo = new Photo();
        $form = $this->createForm(NewPhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photo->setUser($this->getUser());
            $photo->setPostAt(new \DateTimeImmutable());
            $entityManager->persist($photo);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Votre photo à été uploadée'
            );
    
            return $this->redirectToRoute('photo.manage');
        }

        return $this->render('photo/new.html.twig', [
            'newForm' => $form->createView(),
        ]);
    }


}

