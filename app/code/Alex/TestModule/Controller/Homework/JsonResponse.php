<?php

namespace Alex\TestModule\Controller\Homework;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;


class JsonResponse implements ActionInterface
{

    /**
     * @var ResultFactory
     */
    protected ResultFactory $resultFactory;
    protected RequestInterface $request;

    /**
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        RequestInterface $request,
        ResultFactory    $resultFactory
    )
    {
        $this->request = $request;
        $this->resultFactory = $resultFactory;
    }


    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $controllerResult */

        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = ['content' => "Default Router Is - lib/internal/Magento/Framework/App/Router/DefaultRouter.php"];

        return $controllerResult->setData($data);
    }
}
