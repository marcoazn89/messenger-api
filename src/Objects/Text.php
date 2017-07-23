<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Receivable;

use JsonSerializable;

class Text implements Receivable, JsonSerializable
{
    protected $text;
    protected $quickReply;
    protected $quickReplies = [];

    public function __construct(string $text = '', array $quickReplies = [])
    {
        $this->text = $text;
        $this->quickReplies = $quickReplies; 
    }

    public function extractFromData(array $data): void
    {
        $this->text = $data['text'];
        $this->quickReply = $data['quick_reply'];
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getQuickReply(): ?string
    {
        return $this->quickReply;
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
        return 'text';
    }

    public function jsonSerialize(): array
    {
        $data = ['text' => $this->text];

        if (!empty($this->quickReplies)) {
            $data['quick_replies'] = $this->quickReplies;
        }

        return $data;
    }
}