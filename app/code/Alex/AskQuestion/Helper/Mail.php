<?php

namespace Alex\AskQuestion\Helper;

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

class Mail extends AbstractHelper
{
    public const XML_PATH_ENABLED = 'askquestion_options/email_settings/mail_enable';

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
     * Mail constructor
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context               $context,
        StoreManagerInterface $storeManager,
        TransportBuilder      $transportBuilder,
        StateInterface        $inlineTranslation,
        ScopeConfigInterface  $scopeConfig,
    ) {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;

        parent::__construct($context);
    }

    /**
     * @param $customerEmail
     * @param string $customerName
     * @param string $message
     * @param string $phone
     * @param string $productName
     * @param string $sku
     * @return void
     * @throws LocalizedException
     * @throws MailException
     * @throws NoSuchEntityException
     */
    public function sendMail($customerEmail, string $customerName, string $message, string $phone, string $productName, string $sku)
    {

        // Check if the feature is enabled in the system configuration
        if (!$this->isMailSendingEnabled()) {
            return;
        }

        $templateOptions = [
            'area' => Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId()
        ];
        $templateVars = [
            'store' => $this->storeManager->getStore(),
            'customer_name' => $customerName,
            'message' => $message,
            'phone' => $phone,
            'product_name' => $productName,
            'product_sku' => $sku,
        ];

        $from = ['email' => $customerEmail, 'name' => $customerName];
        $this->inlineTranslation->suspend();

        // Send email to admin
        $toAdmin = [$this->getAdminEmail()];
        $this->sendMailTo(
            $toAdmin,
            $templateOptions,
            $templateVars,
            $from,
            'askquestion_options_email_settings_template_settings_admin'
        );

        // Reset the from address for sending email to the customer
        // Use admin's email as the "from" address for the customer
        $from = ['email' => $this->getAdminEmail(), 'name' => 'Admin'];
        $toCustomer = [$customerEmail];
        $this->sendMailTo(
            $toCustomer,
            $templateOptions,
            $templateVars,
            $from,
            'askquestion_options_email_settings_template_settings_customer'
        );

        $this->inlineTranslation->resume();
    }

    /**
     * @param array $to
     * @param array $templateOptions
     * @param array $templateVars
     * @param array $from
     * @param string $templateIdentifier
     * @throws MailException
     * @throws LocalizedException
     */
    private function sendMailTo(array $to, array $templateOptions, array $templateVars, array $from, string $templateIdentifier)
    {
        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateIdentifier)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFromByScope($from)
            ->addTo($to)
            ->getTransport();

        $transport->sendMessage();
    }

    /**
     * Get mail from default Magento variable (Sales Representative Sender Email)
     *
     * @return mixed|string
     */
    private function getAdminEmail()
    {
        $salesIdentEmail = $this->scopeConfig->getValue(
            'trans_email/ident_sales/email',
            ScopeInterface::SCOPE_STORE
        );
        if ($salesIdentEmail) {
            return $salesIdentEmail;
        }
        return '';
    }

    /**
     * Check if the feature is enabled in the system configuration.
     *
     * @return bool
     */
    private function isMailSendingEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
    }
}
