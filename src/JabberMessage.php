<?php
namespace NotificationChannels\Jabber;

class JabberMessage
{
    protected $payload = [];
    protected $content;
    protected $to;

    public function __construct($content = '')
    {
        $this->content($content);
    }

    public static function create($content = '')
    {
        return new static($content);
    }

    public function to($jabberId)
    {
        $this->to = $jabberId;

        return $this;
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    public function options(array $options)
    {
        $this->payload = array_merge($this->payload, $options);

        return $this;
    }

    public function toNotGiven()
    {
        return !isset($this->to);
    }
}
