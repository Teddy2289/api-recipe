<?php

namespace App\Entity;

use App\Entity\Traits\HasIdTrait;
use App\Repository\UnitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    use HasIdTrait;

    #[ORM\Column(length: 64)]
    #[Groups(['get'])]
    private ?string $singular = null;

    #[ORM\Column(length: 64)]
    #[Groups(['get'])]
    private ?string $plural = null;

    /**
     * @var Collection<int, RecipeHasIngredient>
     */
    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: RecipeHasIngredient::class)]
    private Collection $recipeHasIngredients;

    public function __construct()
    {
        $this->recipeHasIngredients = new ArrayCollection();
    }

    public function getSingular(): ?string
    {
        return $this->singular;
    }

    public function setSingular(string $singular): self
    {
        $this->singular = $singular;

        return $this;
    }

    public function getPlural(): ?string
    {
        return $this->plural;
    }

    public function setPlural(string $plural): self
    {
        $this->plural = $plural;

        return $this;
    }

    /**
     * @return Collection<int, RecipeHasIngredient>
     */
    public function getRecipeHasIngredients(): Collection
    {
        return $this->recipeHasIngredients;
    }

    public function addRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): self
    {
        if (!$this->recipeHasIngredients->contains($recipeHasIngredient)) {
            $this->recipeHasIngredients[] = $recipeHasIngredient;
            $recipeHasIngredient->setUnit($this);
        }

        return $this;
    }

    public function removeRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): self
    {
        if ($this->recipeHasIngredients->removeElement($recipeHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasIngredient->getUnit() === $this) {
                $recipeHasIngredient->setUnit(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getSingular().' / '.$this->getPlural();
    }
}
