<?php

namespace App\Controller;

use App\Entity\Notas;
use App\Repository\NotasRepository;
use App\Repository\UsuariosRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class notasController extends AbstractController{

    #[Route(path:"/", name:"indexNotas",methods:["GET"])]
    public function index(NotasRepository $notasRepository,UsuariosRepository $userRepository){
        $usuario = $userRepository -> find(1);
        $notas  = $notasRepository->findBy(["idCread"=> $usuario->getId()]);
        return $this->render("notas/index.html.twig",["notas"=>$notas,"usuario"=>$usuario]);
    }

    #[Route(path:"/login", name:"inicioSesion",methods:["GET"])]
    public function login(){
        
        return $this->render("notas/login.html.twig");
    }

    #[Route(path:"/login", name:"chckSesion",methods:["POST"])]
    public function chckLogin(Request $request, UsuariosRepository $userRepository){
        
        $nomUsuario = $request->request->get("inpNom");
        $usuario = $userRepository -> findOneBy(["nombre"=>$nomUsuario]);
        $pass = $request->request->get("inpPass");

        if($nomUsuario == "" || $pass == ""){
            $this ->addFlash("error","Debes rellenar todos los campos");
            return $this->render("notas/login.html.twig");
        }

        if($usuario == null){
            $this ->addFlash("error","El nombre de usuario no existe");
            return $this->render("notas/login.html.twig");
        }

        if($usuario -> getPass() != $pass){
            $this ->addFlash("error","La contraseña es incorrecta");
            return $this->render("notas/login.html.twig");
        }

        $session = new Session();

        $session -> start();
        $session->set("usuario", $usuario);

        return $this->redirectToRoute("indexNotas");
    }

    #[Route(path:"/crear", name:"crearNota",methods:["POST"])]
    public function crearNota(UsuariosRepository $userRepository,NotasRepository $notasRepository, Request $request, EntityManagerInterface $em){
        $usuario = $userRepository -> find(1);
        $notas  = $notasRepository->findBy(["idCread"=> $usuario->getId()]);

        $nota = new Notas();
        $tituloNota = $request->request->get("inpText");
        $contenidoNota = $request->request->get("inpContenido");

        if($tituloNota == ""|| $contenidoNota == ""){
            $this ->addFlash("error","Debes rellenar todos los campos");
            return $this->render("notas/index.html.twig",["notas"=>$notas,"usuario"=>$usuario]);
        }

        if(!empty($notasRepository -> findBy(["nombreNota" => $tituloNota]))){
            $this ->addFlash("error","Ya existe una nota con ese titulo");
            return $this->render("notas/index.html.twig",["notas"=>$notas,"usuario"=>$usuario]);
        }

        $nota -> setNombreNota($tituloNota);
        $nota -> setContenido($contenidoNota);
        $fechaAct = (new DateTimeImmutable());
        $nota -> setFechaCreacion($fechaAct);
        $nota -> setIdCread($usuario);
        $nota -> setIdCreador($usuario -> getId());

        $em -> persist($nota);
        $em -> flush($nota);
        $this ->addFlash("success","La nota se ha creado correctamente");
        return $this->redirectToRoute("indexNotas");
    }

    #[Route(path:"/eliminar/{id}", name:"eliminarNota",methods:["GET"])]
    public function eliminar($id, UsuariosRepository $userRepository,NotasRepository $notasRepository, EntityManagerInterface $em){
        $usuario = $userRepository -> find(1);
        $notas  = $notasRepository->findBy(["idCread"=> $usuario->getId()]);

        $nota = $notasRepository->findOneBy(["id"=> $id]);
        if($nota == null){
            $this ->addFlash("error","La nota que intentas borrar no existe");
            return $this->render("notas/index.html.twig",["notas"=>$notas,"usuario"=>$usuario]);
        }

        $em -> remove($nota);
        $em -> flush($nota);
        $this ->addFlash("success","La nota se ha eliminado correctamente");
        return $this->redirectToRoute("indexNotas");
    }

    #[Route(path:"/modificar", name:"modificarNota",methods:["POST"])]
    public function modificarNota(NotasRepository $notasRepository, Request $request, EntityManagerInterface $em){
        
        $id = $request-> request ->get("id");

        $nota = $notasRepository->findOneBy(["id"=> $id]);

        $nomNuevo = $request-> request ->get("nomModif");
        $contNuevo = $request-> request ->get("contenModif");

        if($nomNuevo == ""){
            $this ->addFlash("error","El titulo es obligatorio");
            return $this->redirectToRoute("indexNotas");
        }

        $nota -> setNombreNota($nomNuevo);
        $nota -> setContenido($contNuevo);

        $em ->persist($nota);
        $em ->flush($nota);
        $this ->addFlash("success","La nota se ha modificado correctamente");
        return $this->redirectToRoute("indexNotas");
    }
}