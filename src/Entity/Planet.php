<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 *
 * @ORM\Entity(repositoryClass="App\Repository\PlanetRepository")
 */
class Planet
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var integer $id
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string $name
     */
    private $name;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $age
     */
    private $age;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $population
     */
    private $population;

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Description getName function
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Planet
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int $age
     *
     * @return Planet
     */
    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPopulation(): ?int
    {
        return $this->population;
    }

    /**
     * @param int $population
     *
     * @return Planet
     */
    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }
}
