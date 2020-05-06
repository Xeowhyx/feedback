<?php

namespace App\Repository;

use App\Entity\Evolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evolution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evolution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evolution[]    findAll()
 * @method Evolution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvolutionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evolution::class);
    }

    public function findAllEvolutionQuery(): Query
    {
        $query = $this->findEvolutionQuery();
        $query->orderBy('p.date', 'DESC');
        return $query->getQuery();
    }

    private function findEvolutionQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    public function findLatestEvolution(): array
    {
        return $this->findAllEvolutionQuery()
            ->setMaxResults(5)
            ->getResult();
    }
}