<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */

namespace Diamante\AutomationBundle\Tests\Model;

use Diamante\AutomationBundle\Model\Action;
use Diamante\AutomationBundle\Model\EventTriggeredRule;
use Diamante\AutomationBundle\Model\Group;

class EventTriggeredRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCreateEventTriggeredRule()
    {
        $rule = $this->createRule();

        $this->assertInstanceOf('Ramsey\Uuid\Uuid', $rule->getId());
        $this->assertEquals('event_triggered_rule_name', $rule->getName());
        $this->assertEquals(true, $rule->isActive());
        $this->assertInstanceOf('\DateTime', $rule->getUpdatedAt());
        $this->assertInstanceOf('\DateTime', $rule->getCreatedAt());
        $this->assertEquals('ticket', $rule->getTarget());
    }

    /**
     * @test
     */
    public function testUpdate()
    {
        $rule = $this->createRule();
        $rule->update('event_triggered_rule_name_updated', true);

        $this->assertEquals(true, $rule->isActive());
        $this->assertEquals('event_triggered_rule_name_updated', $rule->getName());
    }

    /**
     * @test
     */
    public function testAddGroup()
    {
        $rule = $this->createRule();
        $group = new Group();
        $rule->setGrouping($group);

        $this->assertEquals($group, $rule->getGrouping());
        $this->assertInstanceOf('Diamante\AutomationBundle\Model\Group', $rule->getGrouping());
    }

    /**
     * @test
     */
    public function testAddAction()
    {
        $rule = $this->createRule();
        $action = new Action(
            'NotifyByEmail',
            ['mike@diamantedesk.com'],
            $rule
        );
        $rule->addAction($action);

        $this->assertEquals(true, $rule->getActions()->contains($action));
        $this->assertInstanceOf('Diamante\AutomationBundle\Model\Action', $rule->getActions()->first());
    }

    private function createRule()
    {
        return new EventTriggeredRule('event_triggered_rule_name', 'ticket');
    }
} 
