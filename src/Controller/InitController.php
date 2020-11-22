<?php

namespace App\Controller;

use App\Service\InitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InitController
 * @package App\Controller
 */
class InitController extends AbstractController
{
    /**
     * @var InitService
     */
    private $initService;

    /**
     * InitController constructor.
     * @param InitService $initService
     */
    public function __construct(InitService $initService)
    {
        $this->initService = $initService;
    }

    /**
     * @Route("/", name="init")
     */
    public function index(): Response
    {
        $this->initService->initData();

        return $this->render('test/index.html.twig');
    }
}
