<?php


namespace App;


class UsersController
{
    public function create($request, $response)
    {
        if (empty($request->username) || empty($request->password)) {
            throw new \Exception('Username and passsword cannot be empty', 1);
        }

        if ($this->getUser($request->username)) {
            throw new \Exception('Username already exists', 2);
        }

        $sql = "INSERT INTO users (guid, username, password) VALUES (uuid(), :username, :password)";
        pdo_st($sql, [
            'username' => $request->username,
            'password' => $this->encrypt($request->password),
        ]);

        $sql = "SELECT guid FROM users WHERE id = :id";
        $st = pdo_st($sql, [
            'id' => db()->lastInsertId()
        ]);

        $response->json([
            'message' => 'User created OK',
            'id' => $st->fetchColumn(),
        ]);
    }

    public function login($request, $response)
    {
        if (empty($request->username) || empty($request->password)) {
            throw new \Exception('Username and password cannot be empty', 1);
        }

        $user = $this->getUser($request->username);

        if (empty($user) || $user['password'] != $this->encrypt($request->password)) {
            throw new \Exception('Username or password is incorrect', 3);
        }

        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $sql = "
        UPDATE
            users
        SET
            last_auth = NOW(),
            auth_token = :token,
            lat = :lat,
            lon = :lon,
            country = :country
        WHERE
            guid = :guid
        ";

        $st = pdo_st($sql, [
            'token' => $token,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'country' => $request->country,
            'guid' => $user['guid'],
        ]);

        $response->json([
            'message' => 'Logged in OK, use token for next requests',
            'token' => $token,
        ]);
    }

    public function update($request)
    {
        return 'User profile updated';
    }

    public function saveSettings($request)
    {
        return 'Settings are saved';
    }

    public function index($request)
    {
        return 'Listing all users';
    }

    protected function getUser(string $username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $st = db()->prepare($sql);
        $st->execute([
            'username' => $username
        ]);

        return $st->fetch(\PDO::FETCH_ASSOC);
    }

    protected function encrypt(string $password)
    {
        return hash_hmac('sha256', $password, 's3cr3t');
    }
}
