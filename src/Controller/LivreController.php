<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    public function __construct()
    {
    }
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $user = $this->getUser(); 

        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),'firstname'=>$user->getUsername(),
        ]);

        /*return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);*/
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        

        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            ///////////////////////////////////////////////////
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();
            var_dump($brochureFile);
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $livre->setImage($newFilename);
            }
            ///////////////////
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Livre $livre): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_livre_index');
    }


    //////emprunt livre//////////


    /**
     * @Route("livre/{id}/emprunt", name="emprunt")
     */
    public function emprunterLivre($id, Request $request):Response
    {
        //Création du formulaire
        $form = $this->createForm(EmprunteurType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
          $data = $form->getData();
          $repository = $this->getDoctrine()->getRepository(Emprunteur::class);
          $emprunteur = $repository->findOneBy([ 'numero' => $data['emprunteur'] ]);
          $livre =  $this->getDoctrine()->getRepository(Livre::class)->find($id);
          //On verifie si l'emprunteur existe
          if($emprunteur) {
            $livre->setEmprunteur($emprunteur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index');
          }

        }

        return $this->render('livre/ajoutEmprunteur.html.twig', [
          'id' => $id, 'form' => $form->createView()
        ]);
    }
}
