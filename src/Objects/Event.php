<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Type;

class Event implements Type
{
    public const READ = 'read';
    public const DELIVERED = 'delivered';
    protected $event;

    public function __construct(array $data, string $event)
    {
        $this->event = $event;
    }

    public function getType(): string
    {
        return $this->event;
    }

    public function extractRecievedData(array $message): void
    {
        $this->sender = $message['sender']['id'];
        $this->recipient = new Recipient();
        $this->recipient->setId($message['recipient']['id']);
        $this->timestamp = $message['timestamp'];
        $this->mid = $message['message']['mid'];
        $this->seq = $message['message']['seq'];
        
        if (isset($message['message']['text'])) {
            $this->type = 'text';
            $this->text = $message['message']['text'];

            if (isset($message['message']['quick_reply'])) {
                $this->payload= $message['message']['quick_reply']['payload'];
            }
        } elseif (isset($message['message']['attachments'])) {
            $this->type = 'attachments';
            $this->attachments = $message['message']['attachments'];
        }
    }
}