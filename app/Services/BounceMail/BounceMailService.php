<?php
declare(strict_types=1);

namespace App\Services\BounceMail;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Illuminate\Support\Str;

/**
 * Class BounceMailService
 * @package App\Services\BounceMail
 */
class BounceMailService
{
    /**
     * @var string
     */
    protected $table = 'bounce-mail-address-list';

    /**
     * @var string
     */
    protected $indexName = 'recipient_email-index';

    /**
     * @var string
     */
    protected $partitionKey = 'recipient_email';

    /**
     * @var DynamoDbClient
     */
    protected $client;

    /**
     * DynamoModel constructor.
     * @param DynamoDbClient $client
     */
    public function __construct(DynamoDbClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isBounceMail(string $email): bool
    {
        return !is_null($this->findByEmail($email));
    }

    /**
     * Dynamoから１件レコードを取得
     * @param string $email
     * @return array|null
     */
    private function findByEmail(string $email): ?array
    {
        $parameters = [
            'TableName' => $this->getTable(),
            'IndexName' => $this->indexName,
            'FilterExpression' => "{$this->partitionKey} = :val",
            'ExpressionAttributeValues' => [
                ":val" => ["S" => $email]
            ],
            "ReturnConsumedCapacity" => "TOTAL",
        ];

        try {
            $awsResult = $this->client->scan($parameters)->get('Items');
            if (empty($awsResult)) {
                return null;
            }
            return $awsResult;
        } catch (DynamoDbException $exception) {
            throw $exception;
        }
    }

    /**
     * @return string
     */
    private function getTable(): string
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }
}
