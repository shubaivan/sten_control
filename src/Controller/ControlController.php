<?php

namespace App\Controller;

use App\Entity\Control;
use App\Form\ControlType;
use App\Repository\ControlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControlController extends AbstractController
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
     * @Route("/", name="app_control")
     */
    public function index(): Response
    {
        $keys = Control::getMap();

        $dataTableColumnData = [];

        array_map(function ($k) use (&$dataTableColumnData) {
            $dataTableColumnData[] = ['data' => $k];
        }, $keys);
        return $this->render('control/index.html.twig', [
            'controller_name' => 'ControlController',
            'th_keys' => $keys,
            'dataTbaleKeys' => $dataTableColumnData,
            'separate_filter_column' => ['device_hash'],
        ]);
    }

    /**
     * @Route("/new", name="new_control", methods={"POST", "GET"})
     */
    public function new(Request $request): Response
    {
        // just set up a fresh $CONTROL object (remove the example data)
        $control = new Control();

        $form = $this->createForm(ControlType::class, $control);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$CONTROL` variable has also been updated
            $control = $form->getData();

            // ... perform some action, such as saving the CONTROL to the database
            $this->controlRepository->add($control);
            return $this->redirectToRoute('app_control');
        }

        return $this->renderForm('control/new.html.twig', [
            'form' => $form,
        ]);
    }
}
