<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends AbstractController
{


    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;


    //    #####################    SELECT      ############################

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(PostRepository $postRepository, EntityManagerInterface $em)
    {
        $this->postRepository = $postRepository;
        $this->em = $em;
    }

    /**
     * @Route("/post_list", name="post_list")
     */

    public function index(): Response
    {
        $PostEntities = $this->postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'PostEntities' => $PostEntities
        ]);
    }

    //    #####################    ADD      ############################

    /** @Route("/admin/create_post", name="create_post")
     * @param Request $request
     * @return Response
     */
    public function createPost(Request $request)
    {
        $PostEntity = new Post();
        $form = $this->createForm(PostType::class, $PostEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($PostEntity);

//            $PostEntity->setCreatedAt(new \DateTime());
            $PostEntity->setStatus('0');
            $PostEntity->setNumberView(0);

            $this->em->persist($PostEntity);
            $this->em->flush();

            return $this->redirectToRoute("post_list");
        }

        return $this->render('post/create.html.twig', [
            'controller_name' => 'PostController',
            'form' => $form->createView()

        ]);
    }

    //    #####################    EDIT      ############################


    /**
     * @Route("/admin/edit_post/{id}", name="edit_post")
     * @param Request $request
     * @param string $id
     * @return Response
     */

    public function editPost(Request $request, string $id)
    {
        $postEntity = $this->postRepository->find($id);
        $form = $this->createForm(PostType::class, $postEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($postEntity);
            $this->em->persist($postEntity);
            $this->em->flush();

            return $this->redirectToRoute("post_list");

        }

        return $this->render('post/edit.html.twig', [
            'controller_name' => 'PostController',
            'form' => $form->createView()

        ]);
    }

        //    #####################    DELETE      ############################

        /**
         * @Route("/admin/delete_post/{id}", name="delete_post")
         * @param string $id
         * @return Response
         */

        public function deletePost(string $id)
        {
            $PostEntity = $this->postRepository->find($id);
            $this->em->remove($PostEntity);
            $this->em->flush();

            return $this->redirectToRoute("post_list");
        }


}
