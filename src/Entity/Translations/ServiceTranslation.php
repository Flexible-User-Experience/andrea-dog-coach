<?php

namespace App\Entity\Translations;

use App\Entity\Service;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'lookup_service_unique_idx', columns: ['locale', 'object_id', 'field'])]
class ServiceTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'translations')]
    protected $object;
}
