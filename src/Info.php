<?php

declare(strict_types=1);

namespace AD5jp\PhpChatwork;

/**
 * @method static static title(string $title)
 */
class Info extends Message
{
    protected ?string $title = null;

    /**
     * @param string $title
     * @return static
     */
    protected function title(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
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