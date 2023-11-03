<?php

namespace Alex\Homework11\Controller\Index;

use Alex\Homework11\Model\DisplayConstantsAndMethods;
use Alex\Homework11\Model\FileLister;
use Alex\Homework11\Model\ParameterDisplay;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

class Index extends Action
{

    /**
     * @var DisplayConstantsAndMethods
     */
    protected $displayConstantsAndMethods;
    /**
     * @var FileLister
     */
    protected FileLister $fileLister;
    /**
     * @var ParameterDisplay
     */
    protected ParameterDisplay $parameterDisplay;

    public function __construct(
        Context                    $context,
        DisplayConstantsAndMethods $displayConstantsAndMethods,
        FileLister                 $fileLister,
        ParameterDisplay           $parameterDisplay
    ) {
        $this->displayConstantsAndMethods = $displayConstantsAndMethods;
        $this->fileLister = $fileLister;
        $this->parameterDisplay = $parameterDisplay;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page|(Page&ResultInterface)
     */
    public function execute()
    {
        $data = [
            'constantsAndMethodsData' => $this->displayConstantsAndMethods->displayInfo(),
            'fileListData' => $this->fileLister->getFileList(),
            'parameterDisplayData' => $this->parameterDisplay->getParameters(),
        ];

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getLayout()
            ->createBlock('')
            ->setData('info', $data);

        return $resultPage;
    }
}
