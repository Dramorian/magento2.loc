<?php

namespace Overdose\AdminPanel\Controller\Adminhtml\Friend;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Overdose\LessonOne\Api\Data\FriendInterfaceFactory;
use Overdose\LessonOne\Api\FriendRepositoryInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var FriendInterfaceFactory
     */
    protected $friendFactory;

    /**
     * @var FriendRepositoryInterface
     */
    protected $friendRepository;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param FriendInterfaceFactory $friendFactory
     * @param FriendRepositoryInterface $friendRepository
     */
    public function __construct(
        Context                   $context,
        DataPersistorInterface    $dataPersistor,
        FriendInterfaceFactory    $friendFactory,
        FriendRepositoryInterface $friendRepository
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->friendFactory = $friendFactory;
        $this->friendRepository = $friendRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $model = $this->friendFactory->create();

            $id = (int)$this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->friendRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This friend no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->friendRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the friend.'));
                $this->dataPersistor->clear('friends');
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the friend.'));
            }

            $this->dataPersistor->set('friends', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

}
