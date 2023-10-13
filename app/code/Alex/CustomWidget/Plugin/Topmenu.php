<?php

namespace Alex\CustomWidget\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;

    /**
     * @param NodeFactory $nodeFactory
     */
    public function __construct(
        NodeFactory $nodeFactory
    )
    {
        $this->nodeFactory = $nodeFactory;
    }

    /**
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @param $outermostClass
     * @param $childrenWrapClass
     * @param $limit
     * @return void
     */
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
                                          $outermostClass = '',
                                          $childrenWrapClass = '',
                                          $limit = 0
    )
    {

        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    /**
     * @return array
     */
    protected function getNodeAsArray()
    {
        return [
            'name' => __('CMS Page Link'),
            'id' => 'cms-page-homework',
            'url' => 'https://magento2.loc/alex-cms',
            'has_active' => false,
            'is_active' => false
        ];
    }

}
