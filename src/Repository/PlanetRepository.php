<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Planet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 *
 * @method Planet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planet[]    findAll()
 * @method Planet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanetRepository extends ServiceEntityRepository
{

    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Planet::class);
    }

    /**
     * @param Planet $planet
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Planet $planet): void
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();

        $entityManager->persist($planet);
        $entityManager->flush();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->createQueryBuilder('planet')->select(['planet.id', 'planet.name'])->getQuery()->getResult();
    }
}
