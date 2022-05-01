<?php

declare(strict_types=1);

namespace App\Components\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class SmsComponent
{
    protected $_client;

    /**
     * SmsComponent constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = config('services.twilio');

        try {
            if ($config['api_key']) {
                // APIキー使用
                $this->_client = new Client($config['api_key'], $config['api_secret'], $config['sid']);
            } else {
                $this->_client = new Client($config['sid'], $config['token']);
            }
        } catch (ConfigurationException $e) {
            throw new \Exception('Twilioのcredential情報を.envに設定してください');
        }
    }

    /**
     * Smsを送信する
     * @param string $to 送信先の電話番号
     * @param string $from 送信元として表示する文字列
     * @param string $body 本文
     * @param string $countryCode 国番号
     * @return bool
     */
    public function send(string $to, string $from, string $body, string $countryCode = '81'): bool
    {
        try {
            $this->_client->messages->create(
                "+${countryCode}{$to}",
                [
                    'from'           => $from,
                    'body'           => $body,
                    "statusCallback" => config('services.twilio.status_callback'),
                ]
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return false;
        }

        return true;
    }
}