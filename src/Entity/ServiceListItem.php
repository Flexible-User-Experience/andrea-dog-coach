<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\TranslationTrait;
use App\Entity\Translations\ServiceListItemTranslation;
use App\Repository\ServiceListItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[Gedmo\TranslationEntity(class: ServiceListItemTranslation::class)]
#[ORM\Entity(repositoryClass: ServiceListItemRepository::class)]
class ServiceListItem extends AbstractBase
{
    use NameTrait;
    use PositionTrait;
    use TranslationTrait;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'items')]
    private Service $service;

    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'object', targetEntity: ServiceListItemTranslation::class, cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    #[Assert\NotBlank]
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function setService(Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function addTranslation(ServiceListItemTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ServiceListItemTranslation $translation): self
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
