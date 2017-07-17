<?php
namespace Messenger;

use Messenger\Objects\{Message, Event};
use Generator;

class WebhookService
{
    public function processData(array $entryArr): Generator
    {
        foreach ($entryArr as $entry) {
            if (!empty($entry['messaging'])) {
                foreach ($entry['messaging'] as $obj) {
                    $msg = new Message;
                    $msg->extractRecievedData($obj);
                    yield $msg;
                }
            } else {
                die('not implemented');
            }
        }
    }
}