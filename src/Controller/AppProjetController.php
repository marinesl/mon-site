<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Entity\Projet;
use App\Form\ProjetType;

class AppProjetController extends AbstractController
{
    /**
     * @Route("/app/projet", name="app_projet")
     * Page de la liste de projets
     */
    public function index(): Response
    {
        /**
         * CONFIG
         */
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
        //

        /**
         * ELEMENTS
         */
            // GET les projets
            $projets = $em->getRepository(Projet::class)->findBy(array(), array('annee' => 'DESC'));
        //

        /**
         * VUE
         */
            return $this->render(
                'back/projet.html.twig' ,
                array(
                    'projets' => $projets
                ));
        //
    }

    /**
     * @Route("/app/projet/add", name="app_projet_add")
     * Formulaire d'ajout d'un projet
     */
    public function add(Request $request, SluggerInterface $slugger): Response
    {
        /**
         * CONFIG
         */
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
        //

        /**
         * ELEMENTS
         */
            // NEW projet
            $projet = new Projet();

            // GET Form
            $form = $this->createForm(ProjetType::class, $projet);
        //

        /**
         * TRAITEMENT
         */
            $form->handleRequest($request);
            if ($request->isMethod('POST')) {
        
                if ($form->isSubmitted() && $form->isValid())
                    return $this->submitProjet($request, $em, $slugger, $form, $projet);

            }
        //

        /**
         * VUE
         */
            return $this->render(
                'back/projet_form.html.twig' ,
                array(
                    'form' => $form->createView(),
                ));
        //
    }

    /**
     * @Route("/app/projet/edit/{id}", name="app_projet_edit")
     * Formulaire de modification d'un projet
     */
    public function edit(Request $request, SluggerInterface $slugger, $id): Response
    {
        /**
         * CONFIG
         */
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
        //

        /**
         * ELEMENTS
         */
            // GET projet
            $projet = $em->getRepository(Projet::class)->find($id);

            // GET Form
            $form = $this->createForm(ProjetType::class, $projet);
        //

        /**
         * TRAITEMENT
         */
            $form->handleRequest($request);
            if ($request->isMethod('POST')) {
        
                if ($form->isSubmitted() && $form->isValid())
                    return $this->submitProjet($request, $em, $slugger, $form, $projet);

            }
        //

        /**
         * VUE
         */
            return $this->render(
                'back/projet_form.html.twig' ,
                array(
                    'form' => $form->createView(),
                    'projet' => $projet
                ));
        //
    }

    /**
     * Enregistrement des informations du formulaire pour les projets
     * @param request instance de Request
     * @param em instance de EntityManager
     * @param slugger instance de SluggerInterface
     * @param form instance de ProjetType
     * @param projet instance de Projet
     */
    public function submitProjet($request, $em, $slugger, $form, $projet)
    {
        /**
         * TRAITEMENT
         */
            /** @var UploadedFile $couverture */
            $couverture = $form->get('couverture')->getData();

            // this condition is needed because the 'couverture' field is not required
            // so the file must be processed only when a file is uploaded
            if ($couverture) {
                $originalFilename = pathinfo($couverture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$couverture->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $couverture->move(
                        $this->getParameter('projet_couverture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'couverture' property to store the file name instead of its contents
                $projet->setcouverture($newFilename);
            }
            
            $projet = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();

            return $this->redirectToRoute('app_projet');
        //
    }
}