<?php

namespace Alex\AskQuestion\Controller\Submit;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';

    const STATUS_SUCCESS = 'Success';

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    /**
     * @var \Magento\Framework\Session\SessionManager
     */
    private $session;

    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Session\SessionManager $session
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\App\Action\Context          $context,
        \Magento\Framework\Session\SessionManager      $session
    )
    {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->session = $session;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();

        try {
            // Check if 2 minutes have passed since the last request
            $lastRequestTime = $this->session->getData('last_request_time');
            if ($lastRequestTime && (time() - $lastRequestTime) < 120) {
                throw new LocalizedException(__('You have already submitted a request in the past 2 minutes.
                Please try again later.'));
            }


            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong.
                Probably you were away for quite a long time already.
                Please, reload the page and try again.'));
            }

            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }

            // @TODO: #111 Backend form validation
            // Here we must also process backend validation or all form fields.
            // Otherwise attackers can just copy our page, remove fields validation and send anything they want

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => __('Your request was submitted. We\'ll get in touch with you as soon as possible.')
            ];
            // Update the last request time in the session.
            $this->session->setData('last_request_time', time());

        } catch (LocalizedException $e) {
            $data = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $controllerResult->setData($data);
    }
}
