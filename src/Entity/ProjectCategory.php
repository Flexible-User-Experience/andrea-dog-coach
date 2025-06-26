<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TranslationTrait;
use App\Entity\Translations\ProjectCategoryTranslation;
use App\Repository\ProjectCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[Gedmo\TranslationEntity(class: ProjectCategoryTranslation::class)]
#[ORM\Entity(repositoryClass: ProjectCategoryRepository::class)]
#[UniqueEntity(['name'])]
class ProjectCategory extends AbstractBase
{
    use NameTrait;
    use SlugTrait;
    use TranslationTrait;

    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'object', targetEntity: ProjectCategoryTranslation::class, cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    #[Assert\NotBlank]
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $name;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $slug;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function addTranslation(ProjectCategoryTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ProjectCategoryTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getName() : self::DEFAULT_NULL_STRING;
    }
}
