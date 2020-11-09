<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Node\RenderBlockNode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{

    /**
     * Montre la page qui dit bonjour
     * 
     * @Route ("/hello/{prenom}/age/{age}", name="hello")
     * @Route ("/hello/{prenom}", name="hello_prenom")
     * @Route ("/hello", name="hello_base")
     * @return void
     */
    public function hello(string $prenom = "anonyme", int $age = 0)
    {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
            );
    }

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function home()
    {
        $prenoms = ["David" => 41, "Sandrine" => 34, "Raphael" => 9];

        return $this->render(
            'home.html.twig',
            [
                'title' => "Bonjour à tous !!",
                'text' => "Comment allez vous ?",
                'age' => 12,
                'personnes' => $prenoms
            ]
        );
    }
}
