<?php

namespace Application\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractController
{

    /**
     * Main action
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }

}
