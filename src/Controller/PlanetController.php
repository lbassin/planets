<?php

namespace App\Controller;

use App\Entity\Planet;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Rest\View()
     * @Rest\Post("/planets")
     * @ParamConverter("planet", converter="fos_rest.request_body")
     *
     * @param Planet $planet
     * @param ConstraintViolationListInterface $validationErrors
     *
     * @return Response
     */
    public function postArticleAction(Planet $planet, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            return $this->handleView(View::create($validationErrors, Response::HTTP_BAD_REQUEST));
        }

        /** @var ObjectManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($planet);
        $em->flush();

        return $this->handleView(View::create($planet, Response::HTTP_CREATED));
    }
}
