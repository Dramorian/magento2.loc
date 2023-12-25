<?php

namespace Alex\RequestSample\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\User\Model\UserFactory;


class Mail extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * Mail constructor
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param UserFactory $userFactory
     */
    public function __construct(
        Context               $context,
        StoreManagerInterface $storeManager,
        TransportBuilder      $transportBuilder,
        StateInterface        $inlineTranslation,
        ScopeConfigInterface  $scopeConfig,
        UserFactory           $userFactory
    )
    {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->userFactory = $userFactory;

        parent::__construct($context);
    }

    /**
     * @param $emailFrom
     * @param string $message
     * @param string $customerName
     * @return void
     * @throws LocalizedException
     * @throws MailException
     * @throws NoSuchEntityException
     */
    public function sendMail($emailFrom, string $customerName = '', string $message='')
    {
        $templateOptions = [
            'area' => Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId()
        ];
        $templateVars = [
            'store' => $this->storeManager->getStore(),
            'customer_name' => $customerName,
            'message' => $message
        ];
        $from = ['email' => $emailFrom, 'name' => $customerName];
        $this->inlineTranslation->suspend();
        $to = [$this->getAdminEmail()];
        $transport = $this->transportBuilder->setTemplateIdentifier('request_sample_email_template')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFromByScope($from)
            ->addTo($to)
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

    /**
     * @return mixed|string
     */
    private function getAdminEmail()
    {
        $transEmailSeller = $this->scopeConfig->getValue(
            'trans_email/ident_sales/email',
            ScopeInterface::SCOPE_STORE
        );
        if ($transEmailSeller) {
            return $transEmailSeller;
        }

        $userFactory = $this->userFactory->create();
        if ($userFactory) {
            return $userFactory->getById(1)->getEmail();
        }

        return '';
    }
}
