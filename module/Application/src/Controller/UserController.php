<?php

namespace Application\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package Application\Controller
 */
class UserController extends AbstractController
{

    /**
     * @return ViewModel|Response
     */
    public function loginAction()
    {
        if (true === $this->getRequest()->isPost()) {
            // login
        }

        return new ViewModel();
    }

    /**
     * @return ViewModel|Response
     */
    public function registerAction()
    {
        if (true === $this->getRequest()->isPost()) {
            // register
        }

        return new ViewModel();
    }

}