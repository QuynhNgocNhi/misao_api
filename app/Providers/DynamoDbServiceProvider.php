<?php
declare(strict_types=1);

namespace App\Providers;

use Aws\DynamoDb\DynamoDbClient;
use Aws\Sdk;
use Illuminate\Support\ServiceProvider;

class DynamoDbServiceProvider extends ServiceProvider
{
    /**
     * Dynamo AWS-SDK接続
     */
    public function register()
    {
//        $this->app->singleton(DynamoDbClient::class, function () {
//            $awsSdk = new Sdk(config('bm_dynamodb'));
//            return $awsSdk->createDynamoDb();
//        });
    }
}
