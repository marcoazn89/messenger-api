<?php
namespace Messenger\Objects;

use JsonSerializable;

class QuickReply implements JsonSerializable
{
    public const TEXT = 'text';
    public const LOCATION = 'location';
    public const ATTACHMENT = 'attachment';
    protected $type;
    protected $title;
    protected $payload;
    protected $image;

    public function __construct(string $type)
    {
        $this->type = $type;
    } 

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    public function setImage(string $url): void
    {
        $this->image = $image;
    }

    public function jsonSerialize(): array
    {
        $data = ['content_type' => $this->type];

        if ($this->type === self::LOCATION) {
            return $data;
        } else {
            if (!empty($this->title)) {
                $data['title'] = $this->title;
            }

            if (!empty($this->payload)) {
                $data['payload'] = $this->payload;
            }

            if (!empty($image)) {
                $data['image'] = $this->image;
            }

            return $data; 
        }
    }
}