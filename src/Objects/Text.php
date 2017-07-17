<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Deliverable;
use JsonSerializable;

class Text implements Deliverable, JsonSerializable
{
    protected $text;
    protected $quickReplies;

    public function __construct(string $text = '', array $quickReplies = [])
    {
        $this->text = $text;
        $this->quickReplies = $quickReplies; 
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getQuickreplies(): array
    {
        return $this->quickReplies;
    }

    public function addQuickreply(QuickReply $reply): void
    {
        $this->quickReplies[] = $reply;
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