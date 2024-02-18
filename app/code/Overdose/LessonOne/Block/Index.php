<?php

declare(strict_types=1);

namespace Overdose\LessonOne\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Pager;

class Index extends Template
{
    /**
     * @var \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory
     */
    protected $friendsCollectionFactory;

    public function __construct(
        Context                                                           $context,
        \Overdose\LessonOne\Model\ResourceModel\Collection\FriendsFactory $friendsCollectionFactory
    ) {
        parent::__construct($context);
        $this->friendsCollectionFactory = $friendsCollectionFactory;
    }

    /**
     * @throws LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getFriendCollection()) {
            $pager = $this->getLayout()->createBlock(
                Pager::class,
                'friend.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20, 50 => 50, 100 => 100])
                ->setShowPerPage(true)->setCollection(
                    $this->getFriendCollection()
                );
            $this->setChild('pager', $pager);
            $this->getFriendCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getFriendCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ?: 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ?: 5;

        $collection = $this->friendsCollectionFactory->create();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        return $collection;
    }
}
