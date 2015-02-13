<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Controller;

use Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OAuthController extends Controller
{
    public function oauthAction()
    {
        $googleClient = $this->getGoogleClient();


        $response = new Response();
        //$response->setContent($googleClient->createAuthUrl());
        return $this->redirect($googleClient->createAuthUrl());
    }

    public function oauthcallbackAction(Request $request)
    {
        $googleClient = $this->getGoogleClient();

        $response = new Response();

        if ($request->get('error')) {
            $response->setContent('bzzzz');
            return $response;
        }

        $code = $request->get('code');
        $res = json_decode($googleClient->authenticate($code));

        $googleAuthToken = new GoogleAuthToken();

        //XXX check for token to be actually present
        $googleAuthToken->setRefreshToken($res->refresh_token);

        //XXX only save token once, e.g. remove the existing entry
        $entityManager = $this->getDoctrine()->getEntityManager();
        $entityManager->persist($googleAuthToken);
        $entityManager->flush();

        $response->setContent(var_export($res, true));
        return $response;
    }

    public function useoauthAction()
    {
        $repository = $this->container->get('jimdo.google_auth_token_entity_repository');

        $googleAuthToken = $repository->findOneBy(array());
        $refreshToken = $googleAuthToken->getRefreshToken();


        $googleClient = $this->getGoogleClient();
        $googleClient->refreshToken($refreshToken);

        $accessTokenData = $googleClient->getAccessToken();

        $accessToken = json_decode($accessTokenData);
        $accessToken = $accessToken->access_token;


        $httpClient = $this->container->get('jimdo.buzz.browser');
        $headers = array(
            'Authorization' => 'Bearer ' . $accessToken
        );

        $httpResponse = $httpClient->get('https://www.google.com/cloudprint/search', $headers);

        $response = new Response();
        $response->setContent(
            var_export(
                array(
                    'response' => $httpResponse->getContent(),
                    'token' => $accessToken,
                ),true
            )
        );

        return $response;

    }

    /**
     * @return \Google_Client
     */
    private function getGoogleClient()
    {
        return $this->container->get('google.google_client');
    }
}
