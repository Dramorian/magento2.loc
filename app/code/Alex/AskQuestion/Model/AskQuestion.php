<?php

namespace Alex\AskQuestion\Model;

use Alex\AskQuestion\Api\Data\AskQuestionExtensionInterface;
use Alex\AskQuestion\Api\Data\AskQuestionExtensionInterfaceFactory;
use Alex\AskQuestion\Api\Data\AskQuestionInterface;
use Alex\AskQuestion\Model\ResourceModel\AskQuestion as AskQuestionResource;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

class AskQuestion extends AbstractExtensibleModel implements AskQuestionInterface
{
    public const STATUS_PENDING = 'Pending';

    public const STATUS_ANSWERED = 'Answered';

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    public function __construct(
        Context                    $context,
        Registry                   $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory      $customAttributeFactory,
        StoreManagerInterface      $storeManager,
        AbstractResource           $resource = null,
        AbstractDb                 $resourceCollection = null,
        array                      $data = []
    ) {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource, $resourceCollection, $data);
        $this->storeManager = $storeManager;
    }

    protected function _construct()
    {
        $this->_init(AskQuestionResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData('question_id');
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData('question_id', $id);
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
    public function getQuestion()
    {
        return $this->getData('question');
    }

    /**
     * @inheritDoc
     */
    public function setQuestion($question)
    {
        return $this->setData('question', $question);
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

    /**
     * @inheritDoc
     *
     * @return \Alex\AskQuestion\Api\Data\AskQuestionExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     *
     * @param \Alex\AskQuestion\Api\Data\AskQuestionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Alex\AskQuestion\Api\Data\AskQuestionExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}