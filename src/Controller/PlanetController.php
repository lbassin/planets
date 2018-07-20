<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Planet;
use App\Repository\PlanetRepositoryInterface;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 *
 * @Rest\Route("/api")
 */
class PlanetController extends FOSRestController
{

    /**
     * @var PlanetRepositoryInterface $planetRepository
     */
    private $planetRepository;

    /**
     * PlanetController constructor.
     *
     * @param PlanetRepositoryInterface $planetRepository
     */
    public function __construct(PlanetRepositoryInterface $planetRepository)
    {
        $this->planetRepository = $planetRepository;
    }

    /**
     * @Rest\Post("/planets")
     * @ParamConverter("planet", converter="fos_rest.request_body")
     *
     * @param Planet $planet
     * @param ConstraintViolationListInterface $validationErrors
     *
     * @return Response
     * @throws ORMException
     */
    public function postCreatePlanetAction(Planet $planet, ConstraintViolationListInterface $validationErrors): Response
    {
        if (count($validationErrors) > 0) {
            return $this->handleView(View::create($validationErrors, Response::HTTP_BAD_REQUEST));
        }

        $this->planetRepository->save($planet);

        return $this->handleView(View::create($planet, Response::HTTP_CREATED));
    }

    /**
     * @Rest\Get("/planets")
     *
     * @return Response
     */
    public function getPlanetsAction(): Response
    {
        /** @var Planet[] $planets */
        $planets = $this->planetRepository->getList();

        return $this->handleView(View::create($planets, Response::HTTP_OK));
    }

    /**
     * @Rest\Get("/planets/{id}")
     *
     * @param Planet $planet
     *
     * @return Response
     */
    public function getPlanetAction(Planet $planet): Response
    {
        return $this->handleView(View::create($planet, Response::HTTP_OK));
    }
}
