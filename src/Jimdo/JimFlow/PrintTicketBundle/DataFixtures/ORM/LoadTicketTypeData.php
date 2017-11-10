<?php

namespace Jimdo\JimFlow\PrintTicketBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $types = array(
            array('Task', '#fd8000'),
            array('Bug', '#f40000'),
            array('Feature', '#364e59'),
            array('Draft', '#000000'),
            array('Incident', '#f40000'),
            array('Master Ticket', '#eccd84'),
            array('Jimdo Support', '#0000ff'),
            array('Technical Debt', '#804d00'),
            array('New Employee', '#9eabb0'),
            array('Leaving Employee', '#19aeff'),
            array('onlinemarketing', '#d76cff')
        );

        foreach($types as $type) {
            $ticketType = new TicketType();
            $ticketType->setName($type[0]);
            $ticketType->setBackgroundColor($type[1]);
            $manager->persist($ticketType);
        }

        $manager->flush();
    }
}
