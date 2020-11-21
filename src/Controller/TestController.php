<?php

namespace App\Controller;

use App\Service\TestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TestController
 * @package App\Controller
 */
class TestController extends AbstractController
{
    /**
     * @var TestService
     */
    private $testService;

    /**
     * TestController constructor.
     * @param TestService $testService
     */
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        $this->testService->initData();

        return $this->render('test/index.html.twig');
    }
}
