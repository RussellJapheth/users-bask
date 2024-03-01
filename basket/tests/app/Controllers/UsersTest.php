<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class UsersTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = null;

    public function testCreate()
    {
        $results = $this->withBody(
            json_encode(
                [
                    'email' => 'user@local.co',
                    'firstName' => 'paul',
                    'lastName' => 'malta'
                ]
            )
        )->controller(\App\Controllers\Users::class)
            ->execute('create');

        $results->assertStatus(201);
        $results->assertJSONFragment(
            [
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => [
                    'id' => 1,
                    'email' => 'user@local.co',
                    'firstName' => 'paul',
                    'lastName' => 'malta'
                ]
            ]
        );
    }

    public function testCreateFail()
    {
        $results = $this->withBody(
            json_encode(
                [
                    'email' => 'userlocal.co',
                    'firstName' => '',
                    'lastName' => 'malta'
                ]
            )
        )->controller(\App\Controllers\Users::class)
            ->execute('create');

        $results->assertStatus(400);
        $results->assertJSONFragment(
            [
                'status' => 400,
                'error' => '400',
                'messages' =>
                    [
                        'email' => 'The email field must contain a valid email address.',
                        'firstName' => 'The firstName field is required.',
                    ]
            ]
        );
    }
}
