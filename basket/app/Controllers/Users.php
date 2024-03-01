<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

/**
 * The Users service
 *
 * @package App\Controllers
 */
class Users extends BaseController
{
    use ResponseTrait;

    /**
     * Publishes a user created event.
     *
     * @param mixed $userData The data of the user created.
     *
     * @return void
     */
    protected function publishUserCreatedEvent($userData): void
    {
        Services::sendEvent(
            json_encode($userData),
            "users.create"
        );
    }

    /**
     * Creates a new user.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface Response containing the result of user creation.
     */
    public function create()
    {
        $validation = \Config\Services::validation();

        $validation->setRules(
            [
                'email' => 'required|valid_email',
                'firstName' => 'required',
                'lastName' => 'required',
            ]
        );

        $request = \Config\Services::request();

        if (!$validation->run($request->getJSON(true))) {
            return $this->failValidationErrors(
                $validation->getErrors(),
                400
            );

        }

        $data = $validation->getValidated();

        $usersModel = new UsersModel();

        $usersModel->insert($data);

        $user = $usersModel->getInsertID();

        $this->publishUserCreatedEvent($data);

        return $this->respondCreated(
            [
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => ['id' => $user, ...$data]

            ],
            201
        );
    }

    public function index()
    {
        return $this->respond(
            [
                uniqid()
            ],
            200
        );
    }
}
