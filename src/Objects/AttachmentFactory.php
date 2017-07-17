<?php
namespace Messenger\Objects;

use Messenger\Objects\Interfaces\Attachment;
use JsonSerializable;

class AttachmentFactory
{
    public static function get(array $data): Attachment
    {
    	$a = new Image();
        $className = __NAMESPACE__ . '\\' . ucfirst($data['type']);
        $attachment = new $className();
        $attachment->extractFromData($data);

        return $attachment;
    }
}