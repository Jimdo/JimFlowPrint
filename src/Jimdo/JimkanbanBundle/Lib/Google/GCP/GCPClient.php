<?php
namespace Jimdo\JimkanbanBundle\Lib\Google\GCP;

use \Jimdo\JimkanbanBundle\Lib\Google\GoogleClient;

class GCPClient extends GoogleClient
{

    const SERVICE_NAME = 'cloudprint';
    const SOURCE = 'Jimkanban2';
    const ACCOUNT_TYPE = 'Google';

    /**
     * @return string
     */
    protected function getAccountType()
    {
        return self::ACCOUNT_TYPE;
    }

    /**
     * @return string
     */
    protected  function getSource()
    {
        return self::SOURCE;
    }

    /**
     * @return string
     */
    protected  function getServiceName()
    {
        return self::SERVICE_NAME;
    }

    /**
     * @return \Buzz\Message\Response
     */
    public function getPrinterList()
    {
        return $this->get('http://www.google.com/cloudprint/search');
    }

}
