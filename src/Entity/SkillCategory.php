<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillCategoryRepository")
 */
class SkillCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SkillRow", mappedBy="category", orphanRemoval=true)
     */
    private $skillRows;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon_path;

    public function __construct()
    {
        $this->skillRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|SkillRow[]
     */
    public function getSkillRows(): Collection
    {
        return $this->skillRows;
    }

    public function addSkillRow(SkillRow $skillRow): self
    {
        if (!$this->skillRows->contains($skillRow)) {
            $this->skillRows[] = $skillRow;
            $skillRow->setCategory($this);
        }

        return $this;
    }

    public function removeSkillRow(SkillRow $skillRow): self
    {
        if ($this->skillRows->contains($skillRow)) {
            $this->skillRows->removeElement($skillRow);
            // set the owning side to null (unless already changed)
            if ($skillRow->getCategory() === $this) {
                $skillRow->setCategory(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIconPath(): ?string
    {
        return $this->icon_path;
    }

    public function setIconPath(?string $icon_path): self
    {
        $this->icon_path = $icon_path;

        return $this;
    }
}
