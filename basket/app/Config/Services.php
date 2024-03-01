<?php

namespace Config;

use CodeIgniter\Config\BaseService;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function sendEvent(string $message = "", string $group = "default"): void
    {
        $connection = new AMQPStreamConnection(
            $_ENV['MQ_HOST'],
            $_ENV['MQ_PORT'],
            $_ENV['MQ_USER'],
            $_ENV['MQ_PASSWORD']
        );

        $channel = $connection->channel();

        $channel->queue_declare($group, false, false, false, false);

        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, '', $group);

        $channel->close();
        $connection->close();

    }

    public static function receiveEvents(callable $callback, string $group = "default")
    {
        $connection = new AMQPStreamConnection(
            $_ENV['MQ_HOST'],
            $_ENV['MQ_PORT'],
            $_ENV['MQ_USER'],
            $_ENV['MQ_PASSWORD']
        );
        $channel = $connection->channel();

        $channel->queue_declare($group, false, false, false, false);

        $channel->basic_consume($group, '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }

        $channel->close();
        $connection->close();

    }
}
