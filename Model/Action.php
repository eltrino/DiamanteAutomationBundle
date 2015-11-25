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

namespace Diamante\AutomationBundle\Model;

use Diamante\DeskBundle\Model\Shared\Entity;
use Rhumsaa\Uuid\Uuid;

class Action implements Entity
{
    protected $id;

    protected $actionType;

    protected $actionParameters;

    protected $rule;

    public function __construct($actionType, $actionParameters, $rule)
    {
        $this->id = (string)Uuid::uuid4();
        $this->actionType = $actionType;
        $this->actionParameters = $actionParameters;
        $this->rule = $rule;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getActionType()
    {
        return $this->actionType;
    }

    public function getActionParameters()
    {
        return $this->actionParameters;
    }

    public function getRule()
    {
        return $this->rule;
    }
}