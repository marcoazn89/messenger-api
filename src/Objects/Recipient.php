<?php
namespace Messenger\Objects;

use Messenger\Exceptions\RecipientException;
use JsonSerializable;

class Recipient implements JsonSerializable
{
    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function setName(string $first, string $last)
    {
        $this->name = [
            'first' => $first,
            'last' => $last
        ];
    }

    public function jsonSerialize(): array
    {
        if (!empty($this->id)) {
            return ['id' => $this->id];
        } else {
            if (!empty($this->phone)) {
                $data = ['phone_number' => $this->phone];

                if (!empty($this->name)) {
                    $data['name'] = $this->name;
                }

                return $data;
            }
        }

        throw new RecipientException('Recipient must have at least an id or phone number');
    }
}