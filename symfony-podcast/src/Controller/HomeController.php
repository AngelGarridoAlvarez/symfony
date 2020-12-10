<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'helloWorld' => 'Hola Mundo con Symfony 5'
        ]);
    }

    public  function animales($nombre, $apellidos){

        $title = 'Bienvenido a la página de Animales';
        $animales = array ('gallifante','comadreja','tortuga ninja','palomo cojo');
        $aves = array (
            'tipo' => 'periquito',
            'color' => 'verde',
            'edad' => 2,
            'raza' => 'agaporni');

        return $this->render('home/animales.html.twig',[ /*Le pasamos las variables a la vista*/
            'title' => $title,
            'nombre' => $nombre, //se lo pasamos a la vista,
            'apellidos' => $apellidos,
            'animales' => $animales,
            'aves' => $aves
        ]);
    }


    public function redirigir1(){
        return $this->redirectToRoute('index');
    }
    #http://localhost/symfony-project/symfony-podcast/public/redirigir1

    public function redirigir2(){
        return $this->redirectToRoute('animales', [ #esto me sirve para redirigir a animales pasándole parámetros)
            'nombre' => 'Minotauro',
            'apellidos' => '22'
        ]);
    }
    #http://localhost/symfony-project/symfony-podcast/public/redirigir2

    public function redirigir3(){
        return $this->redirect('http://www.angeldeveloper.es');
    }
    #http://localhost/symfony-project/symfony-podcast/public/redirigir3
}

