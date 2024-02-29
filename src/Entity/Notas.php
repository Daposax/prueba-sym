<?php

namespace App\Entity;

use App\Repository\NotasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotasRepository::class)
 */
class Notas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreNota;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenido;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCreador;

    /**
     * @ORM\ManyToOne(targetEntity=Usuarios::class, inversedBy="notasCreadas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCread;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreNota(): ?string
    {
        return $this->nombreNota;
    }

    public function setNombreNota(string $nombreNota): self
    {
        $this->nombreNota = $nombreNota;

        return $this;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getIdCreador(): ?int
    {
        return $this->idCreador;
    }

    public function setIdCreador(int $idCreador): self
    {
        $this->idCreador = $idCreador;

        return $this;
    }

    public function getIdCread(): ?Usuarios
    {
        return $this->idCread;
    }

    public function setIdCread(?Usuarios $idCread): self
    {
        $this->idCread = $idCread;

        return $this;
    }
}
