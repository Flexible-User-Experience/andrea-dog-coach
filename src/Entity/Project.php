<?php

namespace App\Entity;

use App\Entity\Traits\BeginDateTrait;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\DocumentTrait;
use App\Entity\Traits\EndDateTrait;
use App\Entity\Traits\ImageFileTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\ShowInFrontendTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TranslationTrait;
use App\Entity\Translations\ProjectTranslation;
use App\Manager\AssetsManager;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Gedmo\TranslationEntity(class: ProjectTranslation::class)]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[UniqueEntity(['name'])]
#[Vich\Uploadable]
class Project extends AbstractBase
{
    use BeginDateTrait;
    use DescriptionTrait;
    use DocumentTrait;
    use EndDateTrait;
    use ImageFileTrait;
    use NameTrait;
    use PositionTrait;
    use ShowInFrontendTrait;
    use SlugTrait;
    use TranslationTrait;
    public const int DEFAULT_YEAR = 2024;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProjectTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    #[Assert\Count(min: 1)]
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: ProjectCategory::class)]
    private ?Collection $projectCategories;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProjectImage::class, mappedBy: 'project', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private ?Collection $images;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $name;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $slug;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => self::DEFAULT_YEAR])]
    private int $year = self::DEFAULT_YEAR;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[Assert\Image(maxSize: '10M', mimeTypes: [
        AssetsManager::MIME_IMAGE_JPG_TYPE,
        AssetsManager::MIME_IMAGE_JPEG_TYPE,
        AssetsManager::MIME_IMAGE_PNG_TYPE,
        AssetsManager::MIME_IMAGE_GIF_TYPE,
    ], minWidth: 1200)]
    #[Vich\UploadableField(mapping: 'projects', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[Assert\File(mimeTypes: [AssetsManager::MIME_APPLICATION_PDF_TYPE, AssetsManager::MIME_APPLICATION_PDF_X_TYPE])]
    #[Vich\UploadableField(mapping: 'documents', fileNameProperty: 'documentName')]
    private ?File $documentFile = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $showCustomerNameInFrontend = true;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->projectCategories = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function addTranslation(ProjectTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ProjectTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }

        return $this;
    }

    public function getProjectCategories(): ?Collection
    {
        return $this->projectCategories;
    }

    public function setProjectCategories(?Collection $projectCategories): self
    {
        $this->projectCategories = $projectCategories;

        return $this;
    }

    public function addProjectCategory(ProjectCategory $category): self
    {
        if (!$this->projectCategories->contains($category)) {
            $this->projectCategories->add($category);
        }

        return $this;
    }

    public function removeProjectCategory(ProjectCategory $category): self
    {
        if ($this->projectCategories->contains($category)) {
            $this->projectCategories->removeElement($category);
        }

        return $this;
    }

    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function setImages(?Collection $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function addImage(ProjectImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProject($this);
        }

        return $this;
    }

    public function removeImage(ProjectImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function isShowCustomerNameInFrontend(): bool
    {
        return $this->showCustomerNameInFrontend;
    }

    public function getShowCustomerNameInFrontend(): bool
    {
        return $this->isShowCustomerNameInFrontend();
    }

    public function showCustomerNameInFrontend(): bool
    {
        return $this->isShowCustomerNameInFrontend();
    }

    public function setShowCustomerNameInFrontend(bool $showCustomerNameInFrontend): self
    {
        $this->showCustomerNameInFrontend = $showCustomerNameInFrontend;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getName() : self::DEFAULT_NULL_STRING;
    }
}
