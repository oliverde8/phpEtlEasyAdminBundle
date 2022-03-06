<?php


namespace Oliverde8\PhpEtlEasyAdminBundle\Controller\Admin;

use Oliverde8\PhpEtlBundle\Entity\EtlExecution;
use Oliverde8\PhpEtlBundle\Security\EtlExecutionVoter;
use Oliverde8\PhpEtlBundle\Services\ChainWorkDirManager;
use Oliverde8\PhpEtlBundle\Services\ExecutionContextFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class EtlDownloadFileController extends AbstractController
{
    /** @var ExecutionContextFactory */
    protected $executionContextFactory;

    /**
     * @param ExecutionContextFactory $executionContextFactory
     */
    public function __construct(ExecutionContextFactory $executionContextFactory)
    {
        $this->executionContextFactory = $executionContextFactory;
    }

    /**
     * @Route("/etl/execution/download", name="etl_execution_download_file")
     * @ParamConverter(name="execution", Class="Oliverde8PhpEtlBundle:EtlExecution")
     */
    public function index(EtlExecution $execution, string $filename): Response
    {
        $this->denyAccessUnlessGranted(EtlExecutionVoter::DOWNLOAD, EtlExecution::class);

        $context = $this->executionContextFactory->get(['etl' => ['execution' => $execution]]);
        $file = $context->getFileSystem()->readStream($filename);

        $response = new StreamedResponse(function () use ($file) {
            $outputStream = fopen('php://output', 'wb');
            stream_copy_to_stream($file, $outputStream);
        });

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            "execution-{$execution->getName()}-{$execution->getId()}-" . $filename
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
