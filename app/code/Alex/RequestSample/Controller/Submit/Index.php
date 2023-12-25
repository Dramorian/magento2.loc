<?php

namespace Alex\RequestSample\Controller\Submit;

use Alex\RequestSample\Helper\Mail;
use Alex\RequestSample\Model\RequestSample;
use Alex\RequestSample\Model\RequestSampleFactory;
use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;

class Index extends Action
{
    public const STATUS_ERROR = 'Error';

    public const STATUS_SUCCESS = 'Success';

    /**
     * @var Validator
     */
    private $formKeyValidator;
    private $mailHelper;

    /**
     * @var RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * Index constructor.
     * @param Validator $formKeyValidator
     * @param RequestSampleFactory $requestSampleFactory
     * @param Context $context
     */
    public function __construct(
        Validator            $formKeyValidator,
        RequestSampleFactory $requestSampleFactory,
        Context              $context,
        Mail                 $mailHelper
    )
    {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->requestSampleFactory = $requestSampleFactory;
        $this->mailHelper = $mailHelper;
    }

    /**
     * @return Json
     * @throws Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }

            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }

            // @TODO: #111 Backend form validation
            // Here we must also process backend validation or all form fields.
            // Otherwise attackers can just copy our page, remove fields validation and send anything they want

            /** @var RequestSample $requestSample */
            $requestSample = $this->requestSampleFactory->create();
            $requestSample->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('phone'))
                ->setProductName($request->getParam('product_name'))
                ->setSku($request->getParam('sku'))
                ->setRequest($request->getParam('request'));
            $requestSample->save();

            /**
             * Send Email
             */
            if ($request->getParam('email')) {
                $email = $request->getParam('email');
                $customerName = $request->getParam('name');
                $message = $request->getParam('request');

                $this->mailHelper->sendMail($email, $customerName, $message);
            }

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Your request was submitted. We\'ll get in touch with you as soon as possible.'
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

        /**
         * @var Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $controllerResult->setData($data);
    }
}
