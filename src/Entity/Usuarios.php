<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsuariosRepository::class)
 */
class Usuarios
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pass;

    /**
     * @ORM\OneToMany(targetEntity=Notas::class, mappedBy="idCread", orphanRemoval=true)
     */
    private $notasCreadas;

    public function __construct()
    {
        $this->notasCreadas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * @return Collection<int, Notas>
     */
    public function getNotasCreadas(): Collection
    {
        return $this->notasCreadas;
    }

    public function addNotasCreada(Notas $notasCreada): self
    {
        if (!$this->notasCreadas->contains($notasCreada)) {
            $this->notasCreadas[] = $notasCreada;
            $notasCreada->setIdCread($this);
        }

        return $this;
    }

    public function removeNotasCreada(Notas $notasCreada): self
    {
        if ($this->notasCreadas->removeElement($notasCreada)) {
            // set the owning side to null (unless already changed)
            if ($notasCreada->getIdCread() === $this) {
                $notasCreada->setIdCread(null);
            }
        }

        return $this;
    }
}
