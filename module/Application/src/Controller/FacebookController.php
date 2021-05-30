<?php

declare(strict_types=1);

namespace Application\Controller;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use stdClass;

class FacebookController extends AbstractActionController
{
    public static function getAccessToken()
    {
    }

    public static function getLoginUrl(string $redirectUrl)
    {
        $fb =  new Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => FB_DEFAULT_GRAPH_VERSION,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(MAIN_URL . 'facebook-callback?redirectUrl='.urlencode($redirectUrl), $permissions);
        return $loginUrl;
    }

    public function callbackAction()
    {
        $fb = new Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => FB_DEFAULT_GRAPH_VERSION,
        ]);
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }


        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }
        // Logged in
        //var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        // echo '<h3>Metadata</h3>';
        // var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('525058595541703');
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            // echo '<h3>Long-lived</h3>';
            // var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        $userInfo = $this->getUserInfo($_SESSION['fb_access_token']);

        if ($userInfo) {
            $user = new stdClass();
            $user->firstName = $userInfo->getFirstName();
            $user->lastName = $userInfo->getLastName();
            $user->fullName = $userInfo->getName();
            $user->email = $userInfo->getEmail();
            $user->userType = UserController::$CUSTOMER;

            $userClass = new UserController();
            $user = $userClass->registeOrLoginUser($user);

        }
        $redirectUrl = urldecode($_GET['redirectUrl']);
        header("Location: ".$redirectUrl);
        exit();
        $view = new ViewModel();
        // Disable layouts; `MvcEvent` will use this View Model instead
        $view->setTerminal(true);
        return $view;
    }

    public static function getUserInfo($accessToken)
    {
        $fb = new Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => FB_DEFAULT_GRAPH_VERSION,
        ]);
        $response = $fb->get(
            '/me?fields=name,email,first_name,middle_name,last_name,birthday,gender,location',
            $accessToken
        );
        return $response->getGraphUser();
    }
}
