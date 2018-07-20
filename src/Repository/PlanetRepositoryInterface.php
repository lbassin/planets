<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Planet;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 */
interface PlanetRepositoryInterface
{
    /**
     * @param Planet $planet
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Planet $planet): void;

    /**
     * @return array
     */
    public function getList(): array;
}
