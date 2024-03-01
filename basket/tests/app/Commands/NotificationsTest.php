<?php

namespace App\Commands;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class NotificationsTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = null;

    public function testEventReceived()
    {
        \Config\Services::sendEvent(
            json_encode(
                [
                    'email' => 'user@localhost.com',
                    'firstName' => 'local',
                    'lastName' => 'malta'
                ]
            ),
            "users.create"
        );

        $this->assertFileExists(WRITEPATH.'/notifications.log');
    }


}
