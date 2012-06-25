<?php

namespace Jimdo\JimkanbanBundle\Lib\Filter;

interface FilterInterface {
    public function filter(array $data, $key);
}
