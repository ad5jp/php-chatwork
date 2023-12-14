<?php

declare(strict_types=1);

namespace AD5jp\PhpChatwork;

class Chatwork
{
    private static ?string $token = null;

    private static ?string $room = null;

    public static function setGlobalToken(string $token): void
    {
        self::$token = $token;
    }

    public static function getGlobalToken(): ?string
    {
        return self::$token;
    }

    public static function setGlobalRoom(string $room): void
    {
        self::$room = $room;
    }

    public static function getGlobalRoom(): ?string
    {
        return self::$room;
    }
}