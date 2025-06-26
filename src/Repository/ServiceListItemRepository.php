<?php

namespace App\Repository;

use App\Entity\ServiceListItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceListItem>
 *
 * @method ServiceListItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceListItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceListItem[]    findAll()
 * @method ServiceListItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceListItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceListItem::class);
    }

    public function update(bool $flush = false): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function add(ServiceListItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->update($flush);
    }

    public function remove(ServiceListItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->update($flush);
    }
}
