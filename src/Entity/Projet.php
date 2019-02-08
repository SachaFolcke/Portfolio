<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 */
class Projet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $periode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $compo_groupe;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $langages;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $catch_phrase;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getCompoGroupe(): ?string
    {
        return $this->compo_groupe;
    }

    public function setCompoGroupe(string $compo_groupe): self
    {
        $this->compo_groupe = $compo_groupe;

        return $this;
    }

    public function getLangages(): ?string
    {
        return $this->langages;
    }

    public function setLangages(string $langages): self
    {
        $this->langages = $langages;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCatchPhrase(): ?string
    {
        return $this->catch_phrase;
    }

    public function setCatchPhrase(string $catch_phrase): self
    {
        $this->catch_phrase = $catch_phrase;

        return $this;
    }
}
