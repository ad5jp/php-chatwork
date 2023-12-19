<?php

declare(strict_types=1);

namespace AD5jp\PhpChatwork;

use Exception;
use GuzzleHttp\Client;

/**
 * @method static static token(string $token)
 * @method static static room(string $room)
 * @method static static to(string $user_od)
 * @method static static body(string $body)
 */
class Message
{
    protected ?string $token = null;

    protected ?string $room = null;

    /**
     * @var string[]
     */
    protected array $to = [];

    protected ?string $body = null;

    protected ?string $id = null;

    final public function __construct(string $token = null)
    {
        $this->token = $token;
    }

    /**
     * @param mixed $name
     * @param mixed $arguments
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        $message = new static();
        return $message->$name(...$arguments);
    }

    /**
     * @param mixed $name
     * @param mixed $arguments
     * @return static
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            throw new Exception("method {$name} is not exist");
        }

        return $this->$name(...$arguments);
    }

    /**
     * @param string $token
     * @return static
     */
    protected function token(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param string $room
     * @return static
     */
    protected function room(string $room)
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @param string $user_id
     * @return static
     */
    protected function to(string $user_id)
    {
        $this->to[] = $user_id;
        return $this;
    }

    /**
     * @param string $body
     * @return static
     */
    protected function body(string $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string|null
     */
    public function id(): ?string
    {
        return $this->id;
    }

    /**
     * @return static
     */
    public function send()
    {
        $message = $this->build();

        $room = $this->room ?? Chatwork::getGlobalRoom();
        if ($room === null) {
            throw new Exception('room is not specified');
        }

        $token = $this->token ?? Chatwork::getGlobalToken();
        if ($token === null) {
            throw new Exception('token is not specified');
        }

        $url = "https://api.chatwork.com/v2/rooms/{$room}/messages";
        $options = [
            'headers' => [
                'X-ChatWorkToken' => $token,
                'accept' => 'application/json',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'body' => $message,
            ]
        ];

        $client = new Client();
        $response = $client->post($url, $options);

        if ($response->getStatusCode() > 300) {
            throw new Exception(sprintf('Request Failed (%s)', $response->getStatusCode()));
        }

        $data = json_decode($response->getBody()->getContents());

        $this->id = $data->message_id ?? null;

        return $this;
    }

    /**
     * @return string
     */
    protected function build(): string
    {
        $message = "";

        $message .= $this->buildTo() . "\n";

        $message .= $this->body;

        return $message;
    }

    /**
     * @return string
     */
    protected function buildTo(): string
    {
        $message = "";

        foreach ($this->to as $user_id) {
            $message .= "[To:" . $user_id ."]" . "\n";
        }

        return $message;
    }
}