<?php

namespace Alex\CustomWidget\Block\Widget;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;

class CustomWidget extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "Alex_CustomWidget::widget/custom-widget.phtml";

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var FilterProvider
     */
    private $filterProvider;

    /**
     * @param Template\Context $context
     * @param BlockRepositoryInterface $blockRepository
     * @param FilterProvider $filterProvider
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context         $context,
        BlockRepositoryInterface $blockRepository,
        FilterProvider           $filterProvider,
        StoreManagerInterface    $storeManager,
        array                    $data = []
    )   {
        parent::__construct($context, $data);
        $this->filterProvider = $filterProvider;
        $this->storeManager = $storeManager;
        $this->blockRepository = $blockRepository;

    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBlockContent()
    {
        $content = '';
        if ($this->getStaticBlock()) {
            $storeId = $this->storeManager->getStore()->getId();
            $block = $this->blockRepository->getById($this->getStaticBlock());
            $content = $this->filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent());
        }
        return $content; // Return the content without echoing
    }

    public function getButtonTitle()
    {
        return $this->getData('button_title');
    }
}
