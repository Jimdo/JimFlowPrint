<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;

use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterInterface;

class RelatedIssueFilter implements FilterInterface
{
    /**
     * @param array $data
     * @param string $key
     * 
     * @return array
     */
    public function filter(array $data, $key)
    {
        $issues = [];

        foreach (explode(';', $data[$key]) as $issue) {
            if (!$issue) {
                continue;
            }

            $issueData = explode(',', $issue);

            $issues[$issueData[0]] = $issueData[1];
        }

        $data[$key] = $issues;

        return $data;
    }
}
