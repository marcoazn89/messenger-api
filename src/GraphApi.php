<?php
namespace Messenger;

use Messenger\Objects\Message;
use GuzzleHttp\{Client, Exception\ClientException};

class GraphApi
{
    public const NOTIFY_REGULAR = 'REGULAR';
    public const NOTIFY_SILENT = 'SILENT_PUSH';
    public const NOTIFY_NO_PUSH = 'NO_PUSH';
    public const API_MESSAGES = 'messages';
    public const API_USER_FIELDS = 'fields=first_name,last_name,profile_pic,locale,timezone,gender,is_payment_enabled,last_ad_referral';
    protected $http;
    protected $apiUrl;
    protected $token;

    public function __construct(Client $http, array $config)
    {
        $this->http = $http;
        $this->apiUrl = "{$config['api']}/{$config['version']}";
        $this->token = $config['token'];
    }

    public function sendMessage(Message $message, $notify = self::NOTIFY_REGULAR): array
    {
        $url = "{$this->apiUrl}/me/" . self::API_MESSAGES . "?access_token={$this->token}";
        $msg = $message->getDeliveryMessage();
        $msg['notification_type'] = $notify;
        
        try {
            $response = $this->http->request('POST', $url, [
                'json' => $msg
            ]);
        } catch (ClientException $e) {
            die($e->getMessage());
        }

        return json_decode((string)$response->getBody(), true);
    }

    public function getUserData(string $userId): array
    {
        $url = "{$this->apiUrl}/{$userId}?access_token={$this->token}&" . self::API_USER_FIELDS;

        try {
            $response = $this->http->request('GET', $url);
        } catch (ClientException $e) {
            die($e->getMessage());
        }

        return json_decode((string)$response->getBody(), true);
    }
}