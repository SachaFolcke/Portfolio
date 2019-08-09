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

    /**
     * @ORM\Column(type="integer")
     */
    private $order_index;

    public function __construct()
    {
        $this->skillRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getSkillRows(): array
    {
        $rows = $this->skillRows->toArray();
        usort($rows, function ($a, $b) {
           return $a->getOrderIndex() < $b->getOrderIndex() ? -1 : 1;
        });
        return $rows;
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
