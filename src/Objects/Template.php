<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Receivable;
use JsonSerializable;
use InvalidArgumentException;

class Template implements Receivable, JsonSerializable
{
    public const TYPE_BUTTON = 'button';
    public const TYPE_GENERIC = 'generic';
    public const IMAGE_RATIO_HORIZONTAL = 'horizontal';
    public const IMAGE_RATIO_SQUARE = 'square';
    protected $type;
    protected $text;
    protected $sharable;
    protected $imageRatio;
    protected $buttons;
    protected $elements;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function extractFromData(array $data): void
    {
        $this->url = $data['payload']['url'];
        $this->stickerId = $data['sticker_id'] ?? null;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function sharable(bool $sharable): void
    {
        $this->sharable = $sharable;
    }

    public function setImageRatio(string $ratio): void
    {
        $this->imageRatio = $ratio;
    }

    public function setButtons(array $buttons): void
    {
        $this->buttons = $buttons;
    }

    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }

    public function jsonSerialize()
    {
        $data = [
            'type' => 'template',
            'payload' => [
                'template_type' => $this->type
            ]
        ];

        if (!empty($this->text)) {
            $data['payload']['text'] = $this->text;
        }

        if (!empty($this->buttons)) {
            $data['payload']['buttons'] = $this->buttons;
        }

        if (!empty($this->elements)) {
            $data['payload']['elements'] = $this->elements;
        }

        $this->validate($data);

        return ['attachment' => $data];
    }

    protected function validate(array $data): void
    {
        $validation = false;

        switch ($data['payload']['template_type']) {
            case self::TYPE_BUTTON:
                $validation = isset($data['payload']['text']) && !empty($data['payload']['buttons']);
                break;
            case self::TYPE_GENERIC;
                $validation = isset($data['payload']['elements']);
                break;
            default:
                die('Not yet implemented');
        }

        if (!$validation) {
            throw new InvalidArgumentException("{$data['payload']['template_type']} template is missing required fields");
        }
    }
}