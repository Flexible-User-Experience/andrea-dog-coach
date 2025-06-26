<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\ProjectCategory;
use App\Enum\SortOrderEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function update(bool $flush = false): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function add(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->update($flush);
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->update($flush);
    }

    public function getAllSortedByNameQB(): QueryBuilder
    {
        return $this->createQueryBuilder('p')->orderBy('p.name', SortOrderEnum::ASCENDING->value);
    }

    public function getAllSortedByNameQ(): Query
    {
        return $this->getAllSortedByNameQB()->getQuery();
    }

    public function getAllSortedByName(): array
    {
        return $this->getAllSortedByNameQ()->getResult();
    }

    public function getActiveAndShowInFrontendSortedByYearAndNameQB(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->andWhere('p.showInFrontend = :show')
            ->setParameter('active', true)
            ->setParameter('show', true)
            ->orderBy('p.year', SortOrderEnum::DESCENDING->value)
            ->addOrderBy('p.name', SortOrderEnum::ASCENDING->value)
        ;
    }

    public function getActiveAndShowInFrontendSortedByYearAndNameQ(): Query
    {
        return $this->getActiveAndShowInFrontendSortedByYearAndNameQB()->getQuery();
    }

    public function getActiveAndShowInFrontendSortedByYearAndName(): array
    {
        return $this->getActiveAndShowInFrontendSortedByYearAndNameQ()->getResult();
    }

    public function getProjectsByYearActiveAndShowInFrontendSortedByNameQB(int $year): QueryBuilder
    {
        return $this->getActiveAndShowInFrontendSortedByYearAndNameQB()
            ->andWhere('p.year = :year')
            ->setParameter('year', $year)
        ;
    }

    public function getProjectsByYearActiveAndShowInFrontendSortedByNameQ(int $year): Query
    {
        return $this->getProjectsByYearActiveAndShowInFrontendSortedByNameQB($year)->getQuery();
    }

    public function getProjectsByYearActiveAndShowInFrontendSortedByName(int $year): array
    {
        return $this->getProjectsByYearActiveAndShowInFrontendSortedByNameQ($year)->getResult();
    }

    public function getTotalProjectsAmount(): int
    {
        return count($this->getAllSortedByNameQB()->getQuery()->getResult());
    }

    public function getProjectsByCategory(ProjectCategory $category): array
    {
        return $this->getActiveAndShowInFrontendSortedByYearAndNameQB()
            ->innerJoin('p.projectCategories', 'c')
            ->andWhere('c.id = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAvailableYearsArraySortedByValue(): array
    {
        return array_reverse($this->getAvailableYearsReversedArraySortedByValue());
    }

    public function getAvailableYearsReversedArraySortedByValue(): array
    {
        return $this->getActiveAndShowInFrontendSortedByYearAndNameQB()
            ->select('p.year')
            ->groupBy('p.year')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SCALAR_COLUMN);
    }
}
