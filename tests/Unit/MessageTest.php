<?php

declare(strict_types=1);

use AD5jp\PhpChatwork\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testBasic()
    {
        $id = Message::token(getenv('chatwork_token'))
            ->room(getenv('chatwork_room'))
            ->to(getenv('chatwork_to'))
            ->body("テストです")
            ->send()
            ->id();

        $this->assertIsNumeric($id);
    }
}
