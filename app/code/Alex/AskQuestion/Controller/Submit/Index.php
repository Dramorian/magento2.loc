<?php

namespace Alex\AskQuestion\Controller\Submit;

use Alex\AskQuestion\Api\AskQuestionRepositoryInterface;
use Alex\AskQuestion\Api\Data\AskQuestionInterface;
use Alex\AskQuestion\Helper\Mail;
use Alex\AskQuestion\Model\AskQuestionFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;

class Index implements HttpGetActionInterface, HttpPostActionInterface
{
    public const STATUS_ERROR = 'Error';
    public const STATUS_SUCCESS = 'Success';

    /**
     * @var Validator
     */
    private Validator $formKeyValidator;

    /**
     * @var AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * @var AskQuestionRepositoryInterface
     */
    private $askQuestionRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var Mail
     */
    private $mailHelper;

    /**
     * Submit index constructor
     *
     * @param Validator $formKeyValidator
     * @param AskQuestionFactory $askQuestionFactory
     * @param AskQuestionRepositoryInterface $askQuestionRepository
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param Mail $mailHelper
     */
    public function __construct(
        Validator                      $formKeyValidator,
        AskQuestionFactory             $askQuestionFactory,
        AskQuestionRepositoryInterface $askQuestionRepository,
        RequestInterface               $request,
        ResultFactory                  $resultFactory,
        Mail                           $mailHelper
    ) {
        $this->formKeyValidator = $formKeyValidator;
        $this->askQuestionFactory = $askQuestionFactory;
        $this->askQuestionRepository = $askQuestionRepository;
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->mailHelper = $mailHelper;
    }

    /**
     * @return ResponseInterface|Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = $this->request;

        try {

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
            /** @var AskQuestionInterface $askQuestion */
            $askQuestion = $this->askQuestionFactory->create();
            $askQuestion->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('phone'))
                ->setProductName($request->getParam('product_name'))
                ->setSku($request->getParam('sku'))
                ->setQuestion($request->getParam('question'));

            $this->askQuestionRepository->save($askQuestion);

            /**
             * Send Email
             */
            if ($request->getParam('email')) {
                $email = $request->getParam('email');
                $customerName = $request->getParam('name');
                $message = $request->getParam('question');
                $productName = $request->getParam('product_name');
                $sku = $request->getParam('sku');
                $phone = $request->getParam('phone');

                $this->mailHelper->sendMail($email, $customerName, $message, $phone, $productName, $sku);
            }

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => __('Your request was submitted. We\'ll get in touch with you as soon as possible.')
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
