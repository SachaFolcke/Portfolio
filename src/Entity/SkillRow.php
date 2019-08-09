<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRowRepository")
 */
class SkillRow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SkillCategory", inversedBy="skillRows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_index;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCategory(): ?SkillCategory
    {
        return $this->category;
    }

    public function setCategory(?SkillCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getOrderIndex(): ?int
    {
        return $this->order_index;
    }

    public function setOrderIndex(int $order_index): self
    {
        $this->order_index = $order_index;

        return $this;
    }

    public function orderUp(): self
    {
        $this->order_index--;

        return $this;
    }

    public function orderDown(): self
    {
        $this->order_index++;

        return $this;
    }
}
