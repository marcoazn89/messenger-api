<?php
namespace Messenger\Objects;

use JsonSerializable;

class DefaultAction implements JsonSerializable
{
    public const WEBVIEW_COMPACT = 'compact';
    public const WEBVIEW_TALL = 'tall';
    public const WEBVIEW_FULL = 'full';
    protected $url;
    protected $messengerExtensions;
    protected $webviewHeight;
    protected $fallbackUrl;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function setMessengerExtension(bool $enable): void
    {
        $this->messengerExtensions = $enable;
    }

    public function setWebviewHeight(string $height): void
    {
        $this->webviewHeight = $height;
    }

    public function setFallbackUrl(string $url): void
    {
        $this->fallbackUrl = $url;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'type' => 'web_url',
            'url' => $this->url
        ];

        if (isset($this->messengerExtensions)) {
            $data['messenger_extensions'] = $this->messengerExtensions;
        }

        if (isset($this->webviewHeight)) {
            $data['webview_height_ratio'] = $this->webviewHeight;
        }

        if (isset($this->fallbackUrl)) {
            $data['fallback_url'] = $this->fallbackUrl;
        }

        return $data;
    }
}