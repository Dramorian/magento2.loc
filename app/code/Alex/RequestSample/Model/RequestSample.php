<?php

namespace Alex\RequestSample\Model;

use Alex\RequestSample\Api\Data\RequestSampleInterface;
use Alex\RequestSample\Model\ResourceModel\RequestSample as RequestSampleResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class RequestSample
 */
class RequestSample extends AbstractModel implements RequestSampleInterface
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSED = 'processed';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context               $context,
        Registry              $registry,
        StoreManagerInterface $storeManager,
        AbstractResource      $resource = null,
        AbstractDb            $resourceCollection = null,
        array                 $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(RequestSampleResource::class);
    }

    /**
     * @return array|int|mixed|null
     */
    public function getId()
    {
        return $this->getData('request_id');
    }

    /**
     * @param $id
     * @return RequestSampleInterface|RequestSample
     */
    public function setId($id)
    {
        return $this->setData('request_id', $id);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @return array|mixed|string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @param $name
     * @return RequestSampleInterface|RequestSample
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * @param $email
     * @return RequestSampleInterface|RequestSample
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getPhone()
    {
        return $this->getData('phone');
    }

    /**
     * @param $phone
     * @return RequestSampleInterface|RequestSample
     */
    public function setPhone($phone)
    {
        return $this->setData('phone', $phone);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getProductName()
    {
        return $this->getData('product_name');
    }

    /**
     * @param $productName
     * @return RequestSampleInterface|RequestSample
     */
    public function setProductName($productName)
    {
        return $this->setData('product_name', $productName);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getSku()
    {
        return $this->getData('sku');
    }

    /**
     * @param $sku
     * @return RequestSampleInterface|RequestSample
     */
    public function setSku($sku)
    {
        return $this->setData('sku', $sku);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getRequest()
    {
        return $this->getData('request');
    }

    /**
     * @param $request
     * @return RequestSampleInterface|RequestSample
     */
    public function setRequest($request)
    {
        return $this->setData('request', $request);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * @param $status
     * @return RequestSampleInterface|RequestSample
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getStoreId()
    {
        return $this->getData('store_id');
    }

    /**
     * @param $storeId
     * @return RequestSampleInterface|RequestSample
     */
    public function setStoreId($storeId)
    {
        return $this->setData('store_id', $storeId);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return (int)$this->getData('customer_id');
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->setData('customer_id', $customerId);
    }

    /**
     * @return AbstractModel
     * @throws NoSuchEntityException
     */
    public function beforeSave()
    {
        if (!$this->getStatus()) {
            $this->setStatus(self::STATUS_PENDING);
        }

        if (!$this->getStoreId()) {
            $this->setStoreId($this->storeManager->getStore()->getId());
        }

        return parent::beforeSave();
    }
}
