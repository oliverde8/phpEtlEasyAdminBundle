<?php

declare(strict_types=1);

namespace Oliverde8\PhpEtlEasyAdminBundle\Controller\Admin;

use Oliverde8\PhpEtlBundle\Entity\EtlExecution;
use Oliverde8\PhpEtlBundle\Repository\EtlExecutionRepository;
use Oliverde8\PhpEtlBundle\Security\EtlExecutionVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtlDashboardController extends AbstractController
{
    /**
     * EtlDashboardController constructor.
     */
    public function __construct(protected EtlExecutionRepository $etlExecutionRepository)
    {
    }

    /**
     * @Route("/etl/execution/dashboard", name="etl_execution_dashboard")
     */
    public function index($startDate = null, $endDate = null): Response
    {
        $this->denyAccessUnlessGranted(EtlExecutionVoter::DASHBOARD, EtlExecution::class);

        if (null === $endDate) {
            $endDate = new \DateTime();
        }

        if (null === $startDate) {
            $startDate = new \DateTime('7 days ago');
        }

        // TODO add Acl here for future proofing.
        return $this->render(
            '@Oliverde8PhpEtlEasyAdmin/admin/dashboard.html.twig',
            [
                'num_waiting'     => $this->etlExecutionRepository->getCountInStatus($startDate, $endDate, EtlExecution::STATUS_WAITING),
                'num_running'     => $this->etlExecutionRepository->getCountInStatus($startDate, $endDate, EtlExecution::STATUS_RUNNING),
                'num_success'     => $this->etlExecutionRepository->getCountInStatus($startDate, $endDate, EtlExecution::STATUS_SUCCESS),
                'num_failure'     => $this->etlExecutionRepository->getCountInStatus($startDate, $endDate, EtlExecution::STATUS_FAILURE),
                'max_wait_time'   => $this->etlExecutionRepository->getMaxWaitTime($startDate, $endDate),
                'avg_wait_time'   => $this->etlExecutionRepository->getAvgWaitTime($startDate, $endDate),
                'most_executed'   => $this->etlExecutionRepository->getMostExecutedJobs($startDate, $endDate, 10),
                'most_time_spent' => $this->etlExecutionRepository->getMostTimeSpentJobs($startDate, $endDate, 10),
                'longest'         => $this->etlExecutionRepository->getLongestJobs($startDate, $endDate, 10),
                'crudController'  => EtlExecutionCrudController::class,
            ]
        );
    }
}
