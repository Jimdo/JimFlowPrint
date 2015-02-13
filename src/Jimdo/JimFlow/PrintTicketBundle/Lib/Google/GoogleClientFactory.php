<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google;


class GoogleClientFactory
{

    public function createClient()
    {
        $googleConfig = new \Google_Config();
        $googleConfig->setClientId('');
        $googleConfig->setClientSecret('');
        $googleConfig->setAccessType('offline');
        $googleConfig->setRedirectUri('http://localhost:8080/web/app_dev.php/print/oauth2callback');
        $googleConfig->setApprovalPrompt('force');

        $googleClient = new \Google_Client($googleConfig);
        $googleClient->addScope('https://www.googleapis.com/auth/cloudprint');


        return $googleClient;
    }
}
