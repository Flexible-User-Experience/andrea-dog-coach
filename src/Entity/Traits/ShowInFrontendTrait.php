<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ShowInFrontendTrait
{
    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $showInFrontend = true;

    public function isShowInFrontend(): bool
    {
        return $this->showInFrontend;
    }

    public function getShowInFrontend(): bool
    {
        return $this->isShowInFrontend();
    }

    public function showInFrontend(): bool
    {
        return $this->isShowInFrontend();
    }

    public function setShowInFrontend(bool $showInFrontend): self
    {
        $this->showInFrontend = $showInFrontend;

        return $this;
    }
}
