<?php

declare(strict_types=1);

namespace AD5jp\PhpChatwork;

/**
 * @method static static title(string $title)
 */
class Info extends Message
{
    protected ?string $title = null;

    protected function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    protected function build(): string
    {
        $message = "";

        $message .= $this->buildTo() . "\n";

        $message .= "[info]\n";

        if ($this->title) {
            $message .= "[title]{$this->title}[/title]\n";
        }

        $message .= $this->body;

        $message .= "[/info]";

        return $message;
    }
}