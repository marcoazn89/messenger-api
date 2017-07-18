<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Receivable;

class Location implements Receivable
{
    protected $title;
    protected $url;
    protected $coordinates;

    public function __construct(array $coordinates = [])
    {
        $this->coordinates = $coordinates;
    }

    public function extractFromData(array $data): void
    {
        $this->title = $data['title'];
        $this->url = $data['url'];
        $this->coordinates = $data['payload']['coordinates'];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): void
    {
        $this->coordinates = $coordinates;
    }
}