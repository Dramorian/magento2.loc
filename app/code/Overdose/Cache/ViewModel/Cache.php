<?php

namespace Overdose\Cache\ViewModel;

use DateTimeImmutable;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Cache implements ArgumentInterface
{
    /**
     * @var Session
     */
    protected $customerSession;

    public function __construct(
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * @throws LocalizedException
     */
    public function getCustomerName()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->greeting($this->customerSession->getCustomer()->getName());
        }

        return $this->greeting('Guest');
    }

    /**
     * @param $name
     * @return string
     */
    public function greeting($name)
    {
        return 'Well, hello there, ' . $name;
    }


    /**
     * @return string
     */
    public function getCurrentTime()
    {
        // Set default timezone to Europe/Kyiv
        date_default_timezone_set('Europe/Kiev');

        // Get current time
        $currentTime = time();

        // Restore default timezone (optional)
        date_default_timezone_set(date_default_timezone_get());

        return date('Y-m-d H:i:s', $currentTime);
    }
}
