<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Planet;
use App\Repository\PlanetRepository;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 */
class PlanetController extends FOSRestController
{

    /**
     * This variable contains a PlanetRepository
     *
     * @var PlanetRepository $planetRepository
     */
    private $planetRepository;

    /**
     * PlanetController constructor.
     *
     * @param PlanetRepository $planetRepository
     */
    public function __construct(PlanetRepository $planetRepository)
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
}
