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
namespace Eltrino\DiamanteDeskBundle\Tests\EmailProcessing\Infrastructure\Message\Zend;

use Eltrino\DiamanteDeskBundle\EmailProcessing\Infrastructure\Message\Zend\RawMessageProvider;
use Eltrino\PHPUnit\MockAnnotations\MockAnnotations;

class RawMessageProviderTest extends \PHPUnit_Framework_TestCase
{
    const DUMMY_RAW_MESSAGE = 'dummy_raw_message';

    /**
     * @var RawMessageProvider
     */
    private $messageProvider;

    /**
     * @var \Eltrino\DiamanteDeskBundle\EmailProcessing\Infrastructure\Message\Zend\MessageConverter
     * @Mock \Eltrino\DiamanteDeskBundle\EmailProcessing\Infrastructure\Message\Zend\MessageConverter
     */
    private $converter;

    protected function setUp()
    {
        MockAnnotations::init($this);
        $this->messageProvider = new RawMessageProvider(self::DUMMY_RAW_MESSAGE, $this->converter);
    }

    /**
     * @test
     */
    public function thatMessagesAreFetched()
    {
        $this->converter->expects($this->once())->method('fromRawMessage')
            ->with($this->equalTo(self::DUMMY_RAW_MESSAGE))
            ->will($this->returnValue(new \Zend\Mail\Message()));

        $messages = $this->messageProvider->fetchMessagesToProcess();

        $this->assertNotEmpty($messages);
        $this->assertContainsOnlyInstancesOf('\Eltrino\DiamanteDeskBundle\EmailProcessing\Model\Message', $messages);
    }
}
