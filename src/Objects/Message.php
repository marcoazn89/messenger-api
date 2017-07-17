<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\{Type, Attachment};
use Messenger\Exceptions\MessageException;
use JsonSerializable;
use Generator;

class Message implements Type, JsonSerializable
{
    protected $sender;
    protected $recipient;
    protected $timestamp;
    protected $message;
    protected $payload;
    protected $type;
    protected $text;
    protected $attachments;
    protected $textObj;
    protected $attachmentObj;
    protected $postaback;

    public function extractRecievedData(array $message): void
    {
        $this->sender = $message['sender']['id'];
        $this->recipient = new Recipient();
        $this->recipient->setId($message['recipient']['id']);
        $this->timestamp = $message['timestamp'];

        if (isset($message['message'])) {
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
        } elseif (isset($message['read'])) {
            $this->type = 'read';
        } elseif (isset($message['delivery'])) {
            $this->type = 'delivery';
        } elseif (isset($message['postback'])) {
            $this->type = 'postback';
            $this->postback = $message['postback']['payload'];
        }
    }

    public function getRecievedMessage(): Generator
    {
        if ($this->type === 'text') {
            yield new Text($this->text);
        } elseif ($this->type === 'attachments') {
            foreach ($this->attachments as $attachment) {
                yield AttachmentFactory::get($attachment);
            }
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(Recipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getMid(): string
    {
        return $this->mid;
    }

    public function getSeq(): int
    {
        return $this->seq;
    }

    public function setText(Text $text)
    {
        $this->type = 'text';
        $this->textObj = $text;
    }

    public function setAttachment(Attachment $attachment)
    {
        $this->type = 'attachments';
        $this->attachmentObj = $attachment;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getPostback()
    {
        return $this->postback;
    }

    public function setPostback(string $data)
    {
        $this->postback = $data;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'recipient' => $this->recipient
        ];

        if ($this->type === 'text' && !empty($this->textObj)) {
            $data['message'] = $this->textObj;
        } elseif ($this->type === 'attachments' && !empty($this->attachmentObj)) {
            $data['message'] = $this->attachmentObj;
        } else {
            throw new MessageException('Message requires text or attachment');
        }

        return $data;
    }

    public function getDeliveryMessage(): array
    {
        return $this->jsonSerialize();
    }
}