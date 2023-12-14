<?php

declare(strict_types=1);

use AD5jp\PhpChatwork\Info;
use PHPUnit\Framework\TestCase;

class InfoTest extends TestCase
{
    public function testBasic()
    {
        $id = Info::token(getenv('chatwork_token'))
            ->room(getenv('chatwork_room'))
            ->to(getenv('chatwork_to'))
            ->title("タイトルです")
            ->body("テストです")
            ->send()
            ->id();

        $this->assertIsNumeric($id);
    }
}
