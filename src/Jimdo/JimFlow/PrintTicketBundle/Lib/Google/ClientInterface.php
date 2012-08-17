<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google;

interface ClientInterface
{
    /**
     * @abstract
     * @param $url
     * @param array $headers
     * @return mixed
     */
    public function get($url, $headers = array());

    /**
     * @abstract
     * @param $url
     * @param array $headers
     * @param $content
     * @return mixed
     */
    public function post($url, $headers = array(), $content);
}
