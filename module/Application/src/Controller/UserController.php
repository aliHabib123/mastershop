<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use stdClass;
use User;
use UserMySqlExtDAO;

class UserController extends AbstractActionController
{
    public static $ADMIN = 1;
    public static $SUPPLIER = 2;
    public static $CUSTOMER = 3;
    public static $WAREHOUSE_MANAGER = 4;

    public function registeOrLoginUser($userInfo)
    {
        $user = $this->getUserInfoByEmail($userInfo->email);
        if (!$user) {
            $user = $this->registerUser($userInfo);
        } else {
            $user = $user[0];
        }

        $this->setUserSession($user);
        return $user;
    }

    public function getUserInfoByEmail(string $email)
    {
        $userMySqlExtDAO = new UserMySqlExtDAO();
        return $userMySqlExtDAO->queryByEmail($email);
    }

    public function setUserSession($user)
    {
        $obj = new stdClass();
        $obj->firstName = $user->firstName;
        $obj->lastName = $user->lastName;
        $obj->fullName = $user->firstName . ' ' . $user->lastName;
        if ($user->fullName) {
            $obj->fullName = $user->fullName;
        }
        if ($user->userType) {
            $obj->userType = $user->userType;
        }
        $obj->email = $user->email;
        $obj->id = $user->id;
        $_SESSION['user'] = $obj;
    }

    public function logoutAction(string $redirectUrl = MAIN_URL)
    {
        session_destroy();
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function submitRegisterAction()
    {
        $result = false;
        $msg = "Error";
        $redirectUrl = MAIN_URL;

        $fullname = HelperController::filterInput($this->getRequest()->getPost('full-name'));
        $birthday = HelperController::filterInput($this->getRequest()->getPost('birthday'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $confirmPassword = HelperController::filterInput($this->getRequest()->getPost('confirm-password'));
        $agree = HelperController::filterInput($this->getRequest()->getPost('agree'));
        $redirectUrl = HelperController::filterInput($this->getRequest()->getPost('redirectUrl'));
        //print_r($agree);

        if ($fullname == "" || $birthday == "" || $email == "" || $password == "" || $confirmPassword == "") {
            $msg = "Please fill all inputs";
        } elseif ($password != $confirmPassword) {
            $msg = "Passwords do not match";
        } elseif (!$agree) {
            $msg = "please agree on our terms and conditions!";
        } else {
            $userExists = $this->getUserInfoByEmail($email);
            if ($userExists) {
                $result = false;
                $msg = "This email is already registered";
            } else {
                $firstName = explode(" ", $fullname)[0];
                $userObj = new stdClass();
                $userObj->firstName = $firstName;
                $userObj->lastName = "";
                $userObj->fullName = $fullname;
                $userObj->email = $email;
                $userObj->dob = $birthday;
                $userObj->userType = UserController::$CUSTOMER;
                $userObj->password = password_hash($password, PASSWORD_DEFAULT);
    
                $user = $this->registerUser($userObj);
    
                if ($user) {
                    $this->setUserSession($user);
                    $result = true;
                    $msg = "successfully registered";
                }
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);
        //$response = HelperController::createJsonResponse($result, $msg);
        print_r($response);
        return $this->response;
    }

    public function submitloginAction()
    {
        $result = false;
        $msg = "Wrong email or password!";
        $redirectUrl = MAIN_URL;

        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $redirectUrl = HelperController::filterInput($this->getRequest()->getPost('redirectUrl'));
        //print_r($agree);

        if ($email == "" || $password == "") {
            $msg = "Please fill all inputs";
        } else {
            $userExists = $this->getUserInfoByEmail($email);
            if ($userExists) {
                $user = $userExists[0];
                if ($user && password_verify($password, $user->password)) {
                    $this->setUserSession($user);
                    $result = true;
                    $msg = "successfully logged in!";
                }
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);
        //$response = HelperController::createJsonResponse($result, $msg);
        print_r($response);
        return $this->response;
    }

    public function registerUser($userInfo)
    {
        $userMySqlExtDAO = new UserMySqlExtDAO();
        $userObj = new User();
        $userObj->firstName = $userInfo->firstName;
        $userObj->lastName = $userInfo->lastName;
        $userObj->fullName = $userInfo->fullName;
        $userObj->email = $userInfo->email;
        if ($userInfo->userType) {
            $userObj->userType = $userInfo->userType;
        }
        if ($userInfo->dob) {
            $userObj->dob = $userInfo->dob;
        }
        if ($userInfo->password) {
            $userObj->password = $userInfo->password;
        }
        if ($userInfo->mobile) {
            $userObj->mobile = $userInfo->mobile;
        }
        $userId = $userMySqlExtDAO->insert($userObj);

        if ($userId) {
            $user = $userMySqlExtDAO->load($userId);
        }
        return $user;
    }
}
