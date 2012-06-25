<?php

namespace Jimdo\JimkanbanBundle\Lib\Filter;

interface FilterInterface {

    /**
     * @abstract
     * @param array $data
     * @param $key
     * @return mixed
     */
    public function filter(array $data, $key);
}
