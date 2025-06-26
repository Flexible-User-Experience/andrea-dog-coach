<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait DocumentTrait
{
    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $documentName = null;

    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    public function setDocumentFile(?File $documentFile): self
    {
        $this->documentFile = $documentFile;
        if (null !== $documentFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getDocumentName(): ?string
    {
        return $this->documentName;
    }

    public function setDocumentName(?string $documentName): self
    {
        $this->documentName = $documentName;

        return $this;
    }
}
