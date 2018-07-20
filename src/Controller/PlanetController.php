<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Planet;
use App\Repository\PlanetRepositoryInterface;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
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
        if ($validationErrors->count() > 0) {
            // Une erreur est survenue a cause des données fournies, cette requete tombera toujours en erreur
            return $this->handleView($this->view($validationErrors, Response::HTTP_BAD_REQUEST));
        }

        $this->planetRepository->save($planet);

        // La ressources est bien ajouté en bdd, on indique donc le code 201 (Created)
        return $this->handleView($this->view($planet, Response::HTTP_CREATED));
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

        // Rien à signaler, tout va bien, HTTP 200
        return $this->handleView($this->view($planets, Response::HTTP_OK));
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
        // Rien à signaler, tout va bien, HTTP 200
        return $this->handleView($this->view($planet, Response::HTTP_OK));
    }
}
