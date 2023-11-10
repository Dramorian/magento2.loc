<?php

namespace Alex\RequestSample\Model;

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
 * @package Alex\RequestSample\Model
 *
 * @method int|string getRequestId()
 * @method int|string getName()
 * @method RequestSample setName(string $name)
 * @method string getEmail()
 * @method RequestSample setEmail(string $email)
 * @method string getPhone()
 * @method RequestSample setPhone(string $phone)
 * @method string getProductName()
 * @method RequestSample setProductName(string $productName)
 * @method string getSku()
 * @method RequestSample setSku(string $sku)
 * @method string getRequest()
 * @method RequestSample setRequest(string $request)
 * @method string getCreatedAt()
 * @method string getStatus()
 * @method RequestSample setStatus(string $status)
 * @method int|string getStoreId()
 * @method RequestSample setStoreId(int $storeId)
 */
class RequestSample extends AbstractModel
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
    )
    {
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
