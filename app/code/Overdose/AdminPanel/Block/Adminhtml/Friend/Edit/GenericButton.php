<?php

namespace Overdose\AdminPanel\Block\Adminhtml\Friend\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var RequestInterface
     */
    protected $request;


    /**
     * @param UrlInterface $url
     * @param RequestInterface $request
     */
    public function __construct(
        Context          $context,
        UrlInterface     $url,
        RequestInterface $request
    ) {
        $this->url = $url;
        $this->request = $request;
        $this->context = $context;
    }

    /**
     * @return int
     */
    public function getFriendId()
    {
        return (int)$this->request->getParam('id', 0);
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
