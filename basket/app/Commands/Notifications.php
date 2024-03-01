<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Notifications extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Notifications';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'notifications:listen';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'notifications:listen';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        \Config\Services::receiveEvents(
            function ($msg) {
                file_put_contents(
                    WRITEPATH.'/notifications.log',
                    "Event received[".date('r')."]: ".$msg->getBody().PHP_EOL,
                    FILE_APPEND
                );
            },
            "users.create"
        );
    }
}
