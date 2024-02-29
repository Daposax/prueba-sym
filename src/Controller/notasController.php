<?php

namespace App\Controller;

use App\Repository\NotasRepository;
use App\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class notasController extends AbstractController{

    #[Route(path:"/", name:"indexNotas")]
    public function index(NotasRepository $notasRepository,UsuariosRepository $userRepository){

        $usuario = $userRepository -> find(1);
        $notas  = $notasRepository->findBy(["idCread"=> $usuario->getId()]);
        return $this->render("notas/index.html.twig",["notas"=>$notas,"usuario"=>$usuario]);
    }
}