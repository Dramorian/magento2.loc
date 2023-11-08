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
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Result\Page;

class Index extends Action
{

    /**
     * @var DisplayConstantsAndMethods
     */
    protected DisplayConstantsAndMethods $displayConstantsAndMethods;
    /**
     * @var FileLister
     */
    protected FileLister $fileLister;
    /**
     * @var ParameterDisplay
     */
    protected ParameterDisplay $parameterDisplay;

    /**
     * @param Context $context
     * @param DisplayConstantsAndMethods $displayConstantsAndMethods
     * @param FileLister $fileLister
     * @param ParameterDisplay $parameterDisplay
     */
    public function __construct(
        Context                    $context,
        DisplayConstantsAndMethods $displayConstantsAndMethods,
        FileLister                 $fileLister,
        ParameterDisplay           $parameterDisplay
    )
    {
        $this->displayConstantsAndMethods = $displayConstantsAndMethods;
        $this->fileLister = $fileLister;
        $this->parameterDisplay = $parameterDisplay;
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute()
    {
        $data = [
            'constants' => $this->displayConstantsAndMethods->getConstants(),
            'methods' => $this->displayConstantsAndMethods->getMethodNames(),
            'fileList' => $this->fileLister->listFilesAndFolders(),
            'parameters' => $this->parameterDisplay->displayParameters(),
        ];

        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);


        /** @var Template $block */
        $block = $page->getLayout()->getBlock('class.content');
        $block->setData('info', $data);

        return $page;
    }
}
