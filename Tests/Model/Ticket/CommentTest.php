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
namespace Diamante\DeskBundle\Tests\Model\Ticket;

use Diamante\DeskBundle\Model\Ticket\Comment;
use Diamante\DeskBundle\Model\Ticket\Ticket;
use Diamante\DeskBundle\Model\Branch\Branch;
use Diamante\DeskBundle\Model\Ticket\Source;
use Diamante\DeskBundle\Model\Ticket\Status;
use Diamante\DeskBundle\Model\Ticket\Priority;
use Oro\Bundle\UserBundle\Entity\User;

class CommentTest extends \PHPUnit_Framework_TestCase
{
    const COMMENT_CONTENT      = 'Comment Content';

    public function testCreate()
    {
        $ticket = $this->createTicket();
        $creator = $this->createCreator();
        $comment = new Comment(self::COMMENT_CONTENT, $ticket, $creator);

        $this->assertEquals(self::COMMENT_CONTENT, $comment->getContent());
        $this->assertEquals($ticket, $comment->getTicket());
        $this->assertEquals($creator, $comment->getAuthor());
    }

    public function testUpdateContent()
    {
        $comment = $this->createComment();
        $comment->updateContent('New Comment Content');

        $this->assertEquals('New Comment Content', $comment->getContent());
    }

    private function createComment()
    {
        $comment = new Comment(
            self::COMMENT_CONTENT,
            $this->createTicket(),
            $this->createCreator()
        );

        return $comment;
    }

    private function createTicket()
    {
        $ticket = new Ticket(
            TicketTest::TICKET_SUBJECT,
            TicketTest::TICKET_DESCRIPTION,
            new Branch('DUMMY_NAME', 'DUMMY_DESC'),
            new User(),
            new User(),
            Source::PHONE,
            Priority::PRIORITY_LOW,
            Status::OPEN
        );

        return $ticket;
    }

    private function createCreator()
    {
        return new User();
    }
}
