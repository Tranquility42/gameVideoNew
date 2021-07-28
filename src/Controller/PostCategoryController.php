<?php

namespace App\Controller;

use App\Entity\PostCategory;
use App\Form\PostCategoryType;
use App\Repository\PostCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCategoryController extends AbstractController
{

    /**
     * @var PostCategoryRepository
     */
    private $postCategoryRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PostCategoryController constructor.
     * @param PostCategoryRepository $postCategoryRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(PostCategoryRepository $postCategoryRepository, EntityManagerInterface $em)
    {
        $this->postCategoryRepository = $postCategoryRepository;
        $this->em = $em;
    }


    /**
     * @Route("/admin/post_category_list", name="post_category")
     */

    //    #######    SELECT      #######


    public function index(): Response
    {
        $PostCategoriesEntities = $this->postCategoryRepository->findAll();

        return $this->render('post_category/index.html.twig', [
            'controller_name' => 'PostCategoryController',
            'PostCategoriesEntities' => $PostCategoriesEntities,

        ]);
    }

    //    #######    ADD      #######

    /**
     * @Route("/admin/create_post_category", name="create_post_category")
     * @param Request $request
     * @return Response
     */
    public function creatPostCategory(Request $request)
    {
        $PostCategoriesEntity = new PostCategory();
        $form = $this->createForm(PostCategoryType::class, $PostCategoriesEntity);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($PostCategoriesEntity);
            $this->em->persist($PostCategoriesEntity);
            $this->em->flush();

            return $this->redirectToRoute("post_category");
        }

        return $this->render('post_category/create.html.twig', [
            'controller_name' => 'PostCategoryController',
            'form'=>$form->createView()

        ]);
    }

    //    #######  EDIT     #######

    /**
     * @Route("/admin/edit_post_category/{id}", name="edit_post_category")
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function editPostCategory(Request $request, string $id)
    {
        $PostCategoriesEntity = $this->postCategoryRepository->find($id);
        $form = $this->createForm(PostCategoryType::class, $PostCategoriesEntity);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($PostCategoriesEntity);
            $this->em->persist($PostCategoriesEntity);
            $this->em->flush();

            return $this->redirectToRoute("post_category");

        }

        return $this->render('post_category/edit.html.twig', [
            'controller_name' => 'PostCategoryController',
            'form' => $form->createView()

        ]);
    }

    //    #######  DELETE     #######

    /**
     * @Route("/admin/delete_post_category/{id}", name="delete_post_category")
     * @param string $id
     * @return Response
     */
    public function deletePostCategory(string $id)
    {
        $PostCategoriesEntity = $this->postCategoryRepository->find($id);
        $this->em->remove($PostCategoriesEntity);
        $this->em->flush();

        return $this->redirectToRoute("post_category");
    }
}
