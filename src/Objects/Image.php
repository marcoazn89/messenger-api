<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Receivable;
use JsonSerializable;

class Image implements Receivable, JsonSerializable
{
    protected $url;
    protected $stickerId;
    protected $quickReplies;

    public function __construct(string $url = '', array $quickReplies = [])
    {
        $this->url = $url;
        $this->quickReplies = $quickReplies;
    }

    public function extractFromData(array $data): void
    {
        $this->url = $data['payload']['url'];
        $this->stickerId = $data['sticker_id'] ?? null;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getStickerId(): ?int
    {
        return $this->stickerId;
    }

    public function setStickerid(int $stickerId): void
    {
        $this->stickerId = $stickerId;
    }

    public function getQuickreplies(): array
    {
        return $this->quickReplies;
    }

    public function addQuickreply(QuickReply $reply): void
    {
        $this->quickReplies[] = $reply;
    }

    public function getType(): string
    {
        return 'image';
    }

    public function jsonSerialize(): array
    {
        $data = [
            'Receivable' => [
                'type' => 'image',
                'payload' => [
                    'url' => $this->url
                ]
            ]
        ];

        if (!empty($this->quickReplies)) {
            $data['quick_replies'] = $this->quickReplies;
        }

        return $data;
    }
}