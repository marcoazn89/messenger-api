<?php
namespace Messenger\Objects\Interfaces;

abstract class Attachment implements Deliverable
{
    abstract public function extractFromData(array $data): void;
}