<?php
namespace Alex\CustomerOrder\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Order extends Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
