<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Controller;
use Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthToken;
use Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

class PrintController extends Controller
{
    public function printticketAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimFlowPrintTicketBundle:TemplateView:ticketprint', array($data));

        return $this->doPrint($response->getContent(), $request);
    }

    public function printstoryAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimFlowPrintTicketBundle:TemplateView:storyprint', array($data));

        return $this->doPrint($response->getContent(), $request);
    }

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
        $res = $googleClient->authenticate($code);

        $googleAuthToken = new GoogleAuthToken();

        //XXX check for token to be actually present
        $googleAuthToken->setRefreshToken($res->refresh_token);


        $repository = $this->container->get('jimdo.google_auth_token_entity_repository');
        //XXX NEXT
        //$repository->store($googleAuthToken);


        $response->setContent(var_export($res, true));
        return $response;
    }

    private function doPrint($data, Request $request)
    {

        $this->assertFormValid($request);

        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        $printingService = $this->get('jimdo.gcp_printing');
        $response = new Response();
        $response->setStatusCode(200);

        try {
            $printingService->doPrint($templateData['printer'], $data);

        } catch (\InvalidArgumentException $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    /**
     * @param Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * @return void
     */
    private function assertFormValid(Request $request)
    {
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);

        if (!$form->isValid()) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
    }

    /**
     * @return \Google_Client
     */
    private function getGoogleClient()
    {
        $googleConfig = new \Google_Config();
        $googleConfig->setClientId();
        $googleConfig->setClientSecret();
        $googleConfig->setAccessType('offline');

        $googleClient = new \Google_Client($googleConfig);
        $googleClient->addScope('https://www.googleapis.com/auth/cloudprint');

        $googleClient->setRedirectUri('http://localhost:8080/web/app_dev.php/print/oauth2callback');
        return $googleClient;
    }
}
