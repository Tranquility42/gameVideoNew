<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_logo;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="devices")
     */
    private $Device;

    public function __construct()
    {
        $this->Device = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPathLogo(): ?string
    {
        return $this->path_logo;
    }

    public function setPathLogo(string $path_logo): self
    {
        $this->path_logo = $path_logo;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getDevice(): Collection
    {
        return $this->Device;
    }

    public function addDevice(Game $device): self
    {
        if (!$this->Device->contains($device)) {
            $this->Device[] = $device;
        }

        return $this;
    }

    public function removeDevice(Game $device): self
    {
        $this->Device->removeElement($device);

        return $this;
    }
}
