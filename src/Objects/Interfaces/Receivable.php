<?php
namespace Messenger\Objects\Interfaces;

interface Receivable
{
    public function extractFromData(array $data): void;
    public function getType(): string;
}