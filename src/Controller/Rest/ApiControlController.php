<?php

namespace App\Controller\Rest;

use App\Document\AdrecordProduct;
use App\Entity\Control;
use App\Repository\ControlRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Symfony\Component\HttpFoundation\Request;
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
     * Post available-render-params.
     *
     * @Rest\Post("/api/controls", options={"expose": true})
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
    public function getAvailableRenderParamsAction(Request $request): array
    {
        $bySearchData = $this->controlRepository->fetchBySearchData($request->request->all());

        $totalCount = $this->controlRepository
            ->fetchTotalCount();
        return [
            "draw" => $request->request->get('draw'),
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $bySearchData['count'] ?: $totalCount,
            'data' => $bySearchData['data']
        ];
    }

    /**
     * GET data-table-params.
     *
     * @Rest\Get("/api/data-table-params", options={"expose": true})
     *
     * @Rest\View(statusCode=Response::HTTP_OK)
     *
     * @Operation(
     *     tags={"Control"},
     *     summary="list of data table params."
     * )
     *
     * @return array
     */
    public function getDataTableParamsAction(Request $request): array
    {
        $keys = Control::getMap();

        $dataTableColumnData = [];

        array_map(function ($k) use (&$dataTableColumnData) {
            $dataTableColumnData[] = ['data' => $k];
        }, $keys);

        return [
            'th_keys' => $dataTableColumnData,
            'for_prepare_defs' => $dataTableColumnData,
            'separate_filter_column' => ['device_hash'],
        ];
    }
}