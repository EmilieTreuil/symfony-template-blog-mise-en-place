<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PostType;


/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{


     /**
        * @Route("/", name="home")
        */
        public function index(): Response
        {
            return $this->render('admin/index.html.twig', [
                'controller_name' => 'AdminController INDEX',
            ]);
        }
      /**
     * @Route("/category/add", name="category_add")
     */
    public function addCategory(Request $request): Response
    {
        // On crée une instance vide
        $category = new Category();

        // On instancie le formulaire et on le lie à l'instance de la catégorie
        $form = $this->createForm(CategoryType::class, $category);
        // On récupère le POST dans la requete http
        $form->handleRequest($request);
        // On vérifie qu'on est bien dans un submit et que les données sont correctes
        if($form->isSubmitted() && $form->isValid()){

            // On récupère le doctrine
            $em = $this->getDoctrine()->getManager();
            // on fait un SQL insert
            $em->persist($category);
            // on fait un commit pour valider définitivement
            $em->flush();
            return $this->redirectToRoute('admin_home');

        }
        
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/post/add", name="post_add")
     */
    public function addPost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $post->setActive(false);

            $post->setUser($this->getUser());
            // getUser renvoie à l'utilisateur connecté

            $em->persist($post);
            $em->flush();

            // On génère un message flash de feedback
            $this->addFlash('success', 'Votre article a bien été enregistré');

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
            'action' => 'Création',
        ]);
    }

    /**
     * @Route("/post/update/{id}", name="post_update")
     */
    public function updatePost(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // getUser renvoie à l'utilisateur connecté

            $em->persist($post);
            $em->flush();

            // On génère un message flash de feedback
            $this->addFlash('success', 'Votre article a bien été enregistré');

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
            'action' => 'Modification',
        ]);
    }

        /**
     * @Route("/post/delete/{id}", name="post_delete")
     */
    public function deletePost(Request $request, Post $post): Response
    {

        $em = $this->getDoctrine()->getManager();

        // requête SQL delete
        $em->remove($post);
        $em->flush();

        // On génère un message flash de feedback
        $this->addFlash('success', 'Votre article a bien été supprimé');

        return $this->redirectToRoute('home');
    }
}
