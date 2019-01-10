<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterChain;

class TemplateData
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Filter\FilterChain
     */
    private $filterChain;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param FilterChain $filterChain
     */
    public function __construct(Request $request, FilterChain $filterChain)
    {
        $this->request = $request;
        $this->filterChain = $filterChain;
    }

    /**
     * @return array
     */
    public function getTemplateData()
    {
        return $this->filterChain->filter($this->getData());
    }

    /**
     * @return array
     */
    protected function getData()
    {
        $request = $this->request;

        return array(
            'created' => $request->get('created'),
            'id' => $request->get('id'),
            'issueUrl' => $request->get('issue_url'),
            'title' => $request->get('title'),
            'project' => $request->get('project'),
            'projectLogoUrl' => $request->get('project_logo_url'),
            'reporter' => $request->get('reporter'),
            'dueDate' => $request->get('due_date'),
            'estimatedHours' => $request->get('estimated_hours'),
            'skills' => $request->get('skills'),
            'teamMembers' => $request->get('team_members'),
            'relatedIssues' => $request->get('related_issues'),
            'type' => $request->get('type'),
            'printer' => $request->get('printer')
        );
    }
}
