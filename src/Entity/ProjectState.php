<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectStateRepository")
 */
class ProjectState
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $text_hex_color;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $background_hex_color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projet", mappedBy="state")
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getTextHexColor(): ?string
    {
        return $this->text_hex_color;
    }

    public function setTextHexColor(string $text_hex_color): self
    {
        $this->text_hex_color = $text_hex_color;

        return $this;
    }

    public function getBackgroundHexColor(): ?string
    {
        return $this->background_hex_color;
    }

    public function setBackgroundHexColor(string $background_hex_color): self
    {
        $this->background_hex_color = $background_hex_color;

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Projet $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setState($this);
        }

        return $this;
    }

    public function removeProject(Projet $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getState() === $this) {
                $project->setState(null);
            }
        }

        return $this;
    }
}
