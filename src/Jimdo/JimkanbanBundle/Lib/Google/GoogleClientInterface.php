<?php
namespace Jimdo\JimkanbanBundle\Lib\Google;

interface GoogleClientInterface
{
    public function get($url, $headers = array());
    public function post($url, $headers = array(), $content);
}
