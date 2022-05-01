<?php

declare(strict_types=1);

namespace App\Services\Mail;

use App\Mail\CommonEmail;
use App\Models\EmailTemplate;
use App\Services\BounceMail\BounceMailService;
use Aws\DynamoDb\DynamoDbClient;

/**
 * Class SendMailService
 * @package App\Services\Mail
 */
class SendMailService
{
    protected $bounceMailService;

    public function __construct()
    {
        $dynamoDbClient          = new DynamoDbClient(config('bm_dynamodb'));
        $this->bounceMailService = new BounceMailService($dynamoDbClient);
    }

    /**
     * テンプレートを使用し、メールを送信する
     *
     * @param string $sendTo
     * @param string $templateName
     */
    public function sendPreparedMail(string $sendTo, string $templateName)
    {
        /** @var EmailTemplate $emailTemplate */
        $emailTemplate = EmailTemplate::where('name', $templateName)->first();

        if (!is_null($emailTemplate)) {
            $this->sendMail(
                $sendTo,
                $emailTemplate->subject,
                $emailTemplate->body,
                $emailTemplate->button_url,
                $emailTemplate->button_text
            );
        }
    }

    /**
     * メールを送信する
     *
     * @param string $sendTo
     * @param string $subject
     * @param string $body
     * @param string $buttonUrl
     * @param string $buttonText
     */
    public function sendMail(
        string $sendTo,
        string $subject,
        string $body,
        string $buttonUrl = '',
        string $buttonText = ''
    ) {
        if (!$this->bounceMailService->isBounceMail($sendTo)) {
            $email = new CommonEmail($sendTo, $subject, $body, $buttonUrl, $buttonText);
            $email->sendMail();
        }
    }
}
