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
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(RequestSampleResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData('request_id');
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData('request_id', $id);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * @inheritdoc
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    /**
     * @inheritdoc
     */
    public function getPhone()
    {
        return $this->getData('phone');
    }

    /**
     * @inheritdoc
     */
    public function setPhone($phone)
    {
        return $this->setData('phone', $phone);
    }

    /**
     * @inheritdoc
     */
    public function getProductName()
    {
        return $this->getData('product_name');
    }

    /**
     * @inheritdoc
     */
    public function setProductName($productName)
    {
        return $this->setData('product_name', $productName);
    }

    /**
     * @inheritdoc
     */
    public function getSku()
    {
        return $this->getData('sku');
    }

    /**
     * @inheritdoc
     */
    public function setSku($sku)
    {
        return $this->setData('sku', $sku);
    }

    /**
     * @inheritDoc
     */
    public function getRequest()
    {
        return $this->getData('request');
    }

    /**
     * @inheritDoc
     */
    public function setRequest($request)
    {
        return $this->setData('request', $request);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * @inheritDoc
     */
    public function getStoreId()
    {
        return $this->getData('store_id');
    }

    /**
     * @inheritDoc
     */
    public function setStoreId($storeId)
    {
        return $this->setData('store_id', $storeId);
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
