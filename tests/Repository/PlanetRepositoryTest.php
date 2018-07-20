<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Planet;
use App\Repository\PlanetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 */
class PlanetRepositoryTest extends WebTestCase
{
    /**
     * @var PlanetRepository
     */
    private $repository;
    /**
     * @var RegistryInterface|MockObject
     */
    private $registry;
    /**
     * @var EntityManagerInterface|MockObject
     */
    private $entityManager;
    /**
     * @var ClassMetadata|MockObject
     */
    private $classMetadata;

    /**
     *
     */
    public function setUp()
    {
        $this->classMetadata = $this->getMockBuilder(ClassMetadata::class)->disableOriginalConstructor()->getMock();

        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
        $this->entityManager->method('getClassMetadata')->will($this->returnValue($this->classMetadata));

        $this->registry = $this->getMockBuilder(RegistryInterface::class)->getMock();
        $this->registry->method('getManagerForClass')->will($this->returnValue($this->entityManager));

        /** @var RegistryInterface $entityManager */
        $this->repository = new PlanetRepository($this->registry);
    }

    /**
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function testSaveWithCorrectData(): void
    {
        /** @var Planet $planet */
        $planet = new Planet();

        $this->entityManager->expects($this->once())->method('persist');
        $this->repository->save($planet);
    }
}
