<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;

class TicketIdFilter implements FilterInterface
{

    private function hasHash($id)
    {
        return strpos($id, '#');
    }

    private function prependHash($id)
    {
        return '#' . $id;
    }

    public function filter(array $data, $key)
    {
        $id = $data[$key];

        if (!$this->hasHash($id)) {
            $data[$key] = $this->prependHash($id);
        }

        return $data;
    }
}
