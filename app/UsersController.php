<?php


namespace App;


class UsersController
{

    public function create($request, $response)
    {
        if (empty($request->username) || empty($request->password)) {
            // in real app these text messages normally will be stored and obtained through
            // localization/language files mechanism which is too complicated to implement in test task
            throw new \Exception('Username and passsword cannot be empty', 1);
        }

        if (User::find($request->username)) {
            throw new \Exception('Username already exists', 2);
        }

        $response->json([
            'result' => true,
            'message' => 'User created OK',
            'user_id' => (new User())->create($request),
        ]);
    }

    public function login($request, $response)
    {
        if (empty($request->username) || empty($request->password)) {
            throw new \Exception('Username and password cannot be empty', 1);
        }

        /** @var User|null $user */
        $user = User::find($request->username);

        if (empty($user) || !$user->authorize($request)) {
            throw new \Exception('Username or password is incorrect', 3);
        }

        $response->json([
            'result' => true,
            'message' => 'Logged in OK, use auth_token for further requests',
            'auth_token' => $user->auth_token,
        ]);
    }

    public function update($request, $response)
    {
        /** @var User $user */
        $user = $this->getAuthTokenUser($request);

        $updatedFields = $user->update($request);

        $response->json([
            'result' => true,
            'message' => 'Profile updated',
            'new_values' => $user->getPublicData($updatedFields),
        ]);
    }

    public function updateSettings($request)
    {
        return 'Settings are saved';
    }

    public function index($request)
    {
        return 'Listing all users';
    }

    protected function getAuthTokenUser($request)
    {
        if (empty($request->auth_token)) {
            throw new \Exception('Empty auth_token', 6);
        }

        $user = User::find($request->auth_token, 'auth_token');

        if (empty($user)) {
            throw new \Exception('Provided auth_token is invalid or expired', 7);
        }

        return $user;
    }
}
