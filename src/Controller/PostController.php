<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_home", methods="GET")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $post = $postRepository->findAll();
        $id = 1;

//        dump($post);
        return $this->render('post/index.html.twig', [
            'data' => $post,
            'id' => $id,
        ]);

//        return new Response(json_encode($post), 200);

    }


    /**
     * @Route("/create", name="post_create")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function create(Request $request, FileUploader $fileUploader): Response
    {
        //create a new post
        $post = new Post();
        //set default
//        $post->setTitle('This is title 1.');
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];

            if ($file) {

                //use service instead of default
                $filename = $fileUploader->uploadFile($file);
//                //rename file name
//                $filename =md5(uniqid('', true)) . '.' . $file->guessClientExtension();
//
//                $file->move(
//                    //folder path
//                    $this->getParameter('upload_dir'),
//                    $filename,
//
//                );
                //set image to database
                $post->setImage($filename);
                $em->persist($post);
                $em->flush();
            }


            //message success
            $this->addFlash('success', "Created successfully");


            return $this->redirect('/post/');
        }
        //entity manager
//        $em = $this->getDoctrine()->getManager();

//        $em->persist($post);
//        $em->flush();

        //return value
//        return new Response("Created successfully!");
        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id?}", name="post_show", methods="GET")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
//        $post_by_id = $postRepository->findPostWithCategory($id);
//        $post_by_id = $postRepository->find($id);
//        dump($post_by_id);

        //return to show view
        return $this->render('post/show.html.twig', [
            'data' => $post,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="post_delete")
     * @param Post $post
     * @return Response
     */
    public function remove(Post $post): Response
    {
        //entity manager
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', "Post has been removed successfully");

        return $this->redirect('/post');
    }
}
