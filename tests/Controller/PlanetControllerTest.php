<?php

namespace App\Tests\Controller;

use App\Controller\PlanetController;
use App\Entity\Planet;
use App\Repository\PlanetRepositoryInterface;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\View\ViewHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 */
class PlanetControllerTest extends WebTestCase
{

    /**
     * @var MockObject|PlanetRepositoryInterface
     */
    private $planetRepository;
    /**
     * @var MockObject|ViewHandlerInterface
     */
    private $viewHandler;
    /**
     * @var PlanetController
     */
    private $controller;

    /**
     *
     */
    protected function setUp()
    {
        /** @var MockObject $planetRepository */
        $this->planetRepository = $this->getMockBuilder(PlanetRepositoryInterface::class)->getMock();
        /** @var MockObject $viewHandler */
        $this->viewHandler = $this->getMockBuilder(ViewHandlerInterface::class)->getMock();

        /** @var PlanetController controller */
        $this->controller = new PlanetController($this->planetRepository);
        $this->controller->setViewHandler($this->viewHandler);
    }

    /**
     * @throws ORMException
     */
    public function testPostCreatePlanetActionWithCorrectData()
    {
        /** @var MockObject $planet */
        $planet = $this->getMockBuilder(Planet::class)->getMock();
        /** @var MockObject $validationErrors */
        $validationErrors = $this->getMockBuilder(ConstraintViolationList::class)->getMock();

        $validationErrors
            ->expects($this->once())
            ->method('count')
            ->will($this->returnValue(0));

        $this->planetRepository
            ->expects($this->once())
            ->method('save')
            ->with($planet);

        $this->viewHandler
            ->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new Response()));

        /**
         * @var ConstraintViolationListInterface $validationErrors
         * @var Planet $planet
         */
        $this->controller->postCreatePlanetAction($planet, $validationErrors);
    }

    /**
     * @throws ORMException
     */
    public function testPostCreatePlanetActionWithMissingData()
    {
        /** @var MockObject $planet */
        $planet = $this->getMockBuilder(Planet::class)->getMock();
        /** @var MockObject $validationErrors */
        $validationErrors = $this->getMockBuilder(ConstraintViolationList::class)->getMock();

        $validationErrors
            ->expects($this->once())
            ->method('count')
            ->will($this->returnValue(1));

        $this->planetRepository
            ->expects($this->never())
            ->method('save');

        $this->viewHandler
            ->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new Response()));

        /**
         * @var ConstraintViolationListInterface $validationErrors
         * @var Planet $planet
         */
        $this->controller->postCreatePlanetAction($planet, $validationErrors);
    }

    /**
     *
     */
    public function testGetPlanetsAction()
    {
        $this->planetRepository
            ->expects($this->once())
            ->method('getList')
            ->will($this->returnValue([]));

        $this->viewHandler
            ->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new Response()));

        $this->controller->getPlanetsAction();
    }
}
