<?php

namespace Alex\CustomerOrder\Controller\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Data\Address;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class GetList extends Action
{
    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    public function __construct(
        Context                     $context,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder       $searchCriteriaBuilder,
        FilterBuilder               $filterBuilder
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|Json|\Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        if ($q = $this->getRequest()->getParam('q')) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder
                    ->setField('firstname')
                    ->setValue('%' . $q . '%')
                    ->setConditionType('like')
                    ->create()
            );
        }
        $this->searchCriteriaBuilder->addSortOrder('firstname', 'ASC');
        $this->searchCriteriaBuilder->setPageSize(10);
        $this->searchCriteriaBuilder->setCurrentPage(1);

        $customers = $this->customerRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $data = [];
        foreach ($customers as $customer) {
            if ($addresses = $customer->getAddresses()) {
                /** @var Address $address */
                foreach ($addresses as $address) {

                }
            }
            $data[] = [
                'id' => $customer->getId(),
                'firstName' => $customer->getFirstname(),
                'lastName' => $customer->getLastname(),
                'email' => $customer->getEmail()
            ];
        }

        /** @var Json $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $result->setData([
            'customers' => $data,
            'error' => false
        ]);
    }
}
