<?php

namespace Alex\TestModule\Controller\Homework;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\View;

class ShowPerson implements ActionInterface

{
    /**
     * @var View
     */
    protected View $_view;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $_response;

    /**
     * @param View $view
     * @param ResponseInterface $response
     */
    public function __construct(View $view, ResponseInterface $response)
    {
        $this->_view = $view;
        $this->_response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function execute()
    {

        $name = 'Alexander'; // Replace with your name
        $lastName = 'Salnikov'; // Replace with your last name


        $this->_view->loadLayout();
        $this->_view->getLayout()->getBlock('homework.showperson')
            ->setFirstName($name)->setLastName($lastName);;
        $this->_view->renderLayout();

        return $this->_response;
    }
}

