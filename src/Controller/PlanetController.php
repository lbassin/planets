<?php

namespace App\Controller;

use App\Entity\Planet;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Laurent Bassin <laurent@bassin.info>
 */
class PlanetController extends FOSRestController
{

    /**
     * @Rest\View()
     * @Rest\Post("/planets")
     * @ParamConverter("planet", converter="fos_rest.request_body")
     *
     * @param Planet $planet
     *
     * @return Response
     */
    public function postArticleAction(Planet $planet)
    {
        /** @var ObjectManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($planet);
        $em->flush();

        /** @var View $view */
        $view = $this->view($planet);

        return $this->handleView($view);
    }
}
