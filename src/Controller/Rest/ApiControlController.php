<?php

namespace App\Controller\Rest;

use App\Repository\ControlRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Symfony\Component\HttpFoundation\Response;


class ApiControlController extends AbstractRestController
{
    /** @var ControlRepository */
    private $controlRepository;

    /**
     * @param ControlRepository $controlRepository
     */
    public function __construct(ControlRepository $controlRepository)
    {
        $this->controlRepository = $controlRepository;
    }

    /**
     * get available-render-params.
     *
     * @Rest\Get("/api/controls")
     *
     * @Rest\View(statusCode=Response::HTTP_OK)
     *
     * @Operation(
     *     tags={"Control"},
     *     summary="list of control records."
     * )
     *
     * @return array
     */
    public function getAvailableRenderParamsAction(): array
    {
        return $this->controlRepository->findAll();
    }
}