<?php
namespace Messenger\Objects;

use JsonSerializable;

class Element implements JsonSerializable
{
    protected $title;
    protected $subtitle;
    protected $imageUrl;
    protected $defaultAction;
    protected $buttons;

    public function __construct(string $title, array $buttons = [])
    {
        $this->title = $title;
        $this->buttons = $buttons;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function setImageUrl(string $url): void
    {
        $this->imageUrl = $url;
    }

    public function setDefaultAction(DefaultAction $action): void
    {
        $this->defaultAction = $action;
    }

    public function setButtons(array $buttons): void
    {
        $this->buttons = $buttons;
    }

    public function jsonSerialize(): array
    {
        $data = ['title' => $this->title];

        if (isset($this->subtitle)) {
            $data['subtitle'] = $this->subtitle;
        }

        if (isset($this->imageUrl)) {
            $data['image_url'] = $this->imageUrl;
        }

        if (isset($this->defaultAction)) {
            $data['default_action'] = $this->defaultAction;
        }

        if (!empty($this->buttons)) {
            $data['buttons'] = $this->buttons;
        }

        return $data;
    }
}