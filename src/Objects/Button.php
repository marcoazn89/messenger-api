<?php
namespace Messenger\Objects;

use JsonSerializable;
use InvalidArgumentException;

class Button implements JsonSerializable
{
    public const TYPE_WEB = 'web_url';
    public const TYPE_POSTBACK = 'postback';
    public const TYPE_PHONE = 'phone_number';
    public const TYPE_SHARE = 'element_share';
    public const TYPE_PAYMENT = 'payment';
    public const WEBVIEW_COMPACT = 'compact';
    public const WEBVIEW_TALL = 'tall';
    public const WEBVIEW_FULL = 'full';
    protected $type;
    protected $title;
    protected $url;
    protected $webviewHeight;
    protected $extensions;
    protected $fallbackUrl;
    protected $webviewShareButton;
    protected $payload;
    protected $shareContents;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setWebviewHeight(string $height): void
    {
        $this->webviewHeight = $height;
    }

    public function setExtensions(bool $extensions): void
    {
        $this->extensions = $extensions;
    }

    public function setFallbackUrl(string $fallback): void
    {
        $this->fallbackUrl = $fallback;
    }

    public function setWebviewShareButton(string $shareButton): void
    {
        $this->webviewShareButton = $shareButton;
    }

    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    public function setShareContent(Template $template): void
    {
        $this->shareContents = $template;
    }

    public function jsonSerialize(): array
    {
        $data = ['type' => $this->type];

        if (!empty($this->title)) {
            $data['title'] = $this->title;
        }

        if (!empty($this->url)) {
            $data['url'] = $this->url;
        }

        if (!empty($this->webviewHeight)) {
            $data['webview_height_ratio'] = $this->webviewHeight;
        }

        if (!empty($this->payload)) {
            $data['payload'] = $this->payload;
        }

        if (!empty($this->shareContents)) {
            $data['share_contents'] = $this->shareContents;
        }

        $this->validate($data);

        return $data;
    }

    protected function validate(array $data): void
    {
        $validation = false;

        switch ($data['type']) {
            case self::TYPE_WEB:
                $validation = isset($data['title']) && isset($data['url']);
                break;
            case self::TYPE_POSTBACK;
                $validation = isset($data['title']) && isset($data['payload']);
                break;
            default:
                die('Not yet implemented');
        }

        if (!$validation) {
            throw new InvalidArgumentException("{$data['type']} button is missing required fields");
        }
    }
}