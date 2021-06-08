<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel([]);
    }

    public function contactSubmitAction(){
        $result = false;
        $msg = "Error";
        $fullName = HelperController::filterInput($this->getRequest()->getPost('full-name'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $message = HelperController::filterInput($this->getRequest()->getPost('message'));

        if($fullName == "" || $email == "" || $mobile == "" || $message == ""){
            $msg = "Please fill all required inputs!";
        } else {
            $result = true;
            $msg = "Your Message has been send.";
        }        
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
        ]);

        print_r($response);
        return $this->response;
    }
}
