<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //annotations
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
//        return $this->json([
//            'message'=>'Welcome!',
//            'name' => 'thorn'
//        ]);
//        return new Response('<h1>Welcome!</h1>');
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/user/{name?}", name="user")
     * @param Request $request
     * @return Response
     */
    public function user(Request $request): Response
    {
        //log all req
//        dump($request->get('name'));

        //get value from param
        $name = $request->get('name');
        return new Response("<h1>Welcome2! ".$name."</h1>");
    }

    /**
     * @Route("/welcome/{data}", name="welcome")
     * @param Request $request
     * @return Response
     */
    public function welcome(Request $request): Response
    {
        $data = $request->get('data');
        return $this->render('home/welcome.html.twig', [
            'data' => $data,
        ]);
    }
}
