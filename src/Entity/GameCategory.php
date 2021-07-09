<?php

namespace App\Entity;

use App\Repository\GameCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameCategoryRepository::class)
 */
class GameCategory
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
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="game")
     */
    private $gameCategory;

    public function __construct()
    {
        $this->gameCategory = new ArrayCollection();
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

    /**
     * @return Collection|Game[]
     */
    public function getGameCategory(): Collection
    {
        return $this->gameCategory;
    }

    public function addGameCategory(Game $gameCategory): self
    {
        if (!$this->gameCategory->contains($gameCategory)) {
            $this->gameCategory[] = $gameCategory;
            $gameCategory->setGame($this);
        }

        return $this;
    }

    public function removeGameCategory(Game $gameCategory): self
    {
        if ($this->gameCategory->removeElement($gameCategory)) {
            // set the owning side to null (unless already changed)
            if ($gameCategory->getGame() === $this) {
                $gameCategory->setGame(null);
            }
        }

        return $this;
    }
}
