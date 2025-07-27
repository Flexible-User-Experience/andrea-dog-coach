<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\ImageFileTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\ShowInFrontendTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TranslationTrait;
use App\Entity\Translations\ServiceTranslation;
use App\Manager\AssetsManager;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Gedmo\TranslationEntity(class: ServiceTranslation::class)]
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[Vich\Uploadable]
class Service extends AbstractBase
{
    use DescriptionTrait;
    use ImageFileTrait;
    use NameTrait;
    use PositionTrait;
    use SlugTrait;
    use ShowInFrontendTrait;
    use TranslationTrait;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ServiceImage::class, mappedBy: 'service', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private ?Collection $items;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ServiceTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    #[Assert\NotBlank]
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $slug;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Assert\Image(maxSize: '10M', mimeTypes: [
        AssetsManager::MIME_IMAGE_JPG_TYPE,
        AssetsManager::MIME_IMAGE_JPEG_TYPE,
        AssetsManager::MIME_IMAGE_PNG_TYPE,
        AssetsManager::MIME_IMAGE_GIF_TYPE,
    ], minWidth: 1024)]
    #[Vich\UploadableField(mapping: 'services', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function addItem(ServiceImage $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setService($this);
        }

        return $this;
    }

    public function removeItem(ServiceImage $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }

        return $this;
    }

    public function getItems(): ?Collection
    {
        return $this->items;
    }

    public function setItems(?Collection $items): void
    {
        $this->items = $items;
    }

    public function addTranslation(ServiceTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ServiceTranslation $translation): self
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
