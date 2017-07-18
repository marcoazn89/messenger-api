<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Receivable;
use JsonSerializable;

class AttachmentFactory
{
    public static function get(array $data): Receivable
    {
    	$a = new Image();
        $className = __NAMESPACE__ . '\\' . ucfirst($data['type']);
        $attachment = new $className();
        $attachment->extractFromData($data);

        return $attachment;
    }
}