<?php
namespace Jimdo\JimkanbanBundle\Lib\Google;

interface ClientInterface
{
    public function get($url, $headers = array());
    public function post($url, $headers = array(), $content);
}
