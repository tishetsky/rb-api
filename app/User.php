<?php


namespace App;


use App\Base\Model;

class User extends Model
{
    // this normally should be put into some global definition of constants and
    // values, but for test task purposes will be left here
    const AGE_MIN_VALUE = 12;

    protected $table = 'users';

    protected $user_id;
    protected $username;
    protected $password;
    protected $name;
    protected $age;
    protected $avatar;

    protected $showFields = [
        'user_id',
        'username',
        'name',
        'age',
    ];

    public function create($request)
    {
        $sql = "INSERT INTO
            `{$this->table}`
            (user_id, username, password)
        VALUES
            (uuid(), :username, :password)
        ";

        pdo_st($sql, [
            'username' => $request->username,
            'password' => encrypted($request->password),
        ]);

        $this->id = db()->lastInsertId();
        $this->load();

        return $this->user_id;
    }

    public function update($request)
    {
        $errors = [];
        $fields = [];

        // in real app these validations should be done by some validator engine using array of rules and
        // error messages, not individually
        if (isset($request->name)) {
            if (empty($request->name)) {
                $errors[] = 'Name cannot be empty';
            } else {
                $fields['name'] = $request->name;
            }
        }

        if (isset($request->age)) {
            $request->age = intval($request->age);
            if ($request->age < self::AGE_MIN_VALUE) {
                $errors[] = 'Age must be at least ' . self::AGE_MIN_VALUE;
            } else {
                $fields['age'] = $request->age;

            }
        }

        if (isset($request->avatar) && !$this->isValidImage($request->avatar, $errorMsg)) {
            $errors[] = $errorMsg;
        }

        if (!empty($errors)) {
            throw new \Exception('Profile update failed: ' . implode(', ', $errors), 5);
        }

        if (!empty($fields)) {
            $params['user_id'] = $this->user_id;
            $values = [];

            foreach ($fields as $key => $value) {
                $values[] = "{$key} = :{$key}";
                $params[$key] = $request->$key;
            }

            $sql = implode(', ', $values);

            $sql = "UPDATE `{$this->table}` SET {$sql} WHERE user_id = :user_id";
            $st = pdo_st($sql, $params);
        }

        if (!empty($request->avatar)) {
            $sql = "UPDATE avatars SET content = :content WHERE user_id = :user_id";
            pdo_st($sql, [
                'content' => $request->avatar,
                'user_id' => $this->user_id,
            ]);
        }

        $this->load();

        return array_keys($fields);
    }

    public function getPublicData(array $keys = [])
    {
        $data = [];

        if (empty($keys)) {
            $keys = $this->showFields;
        }

        foreach ($keys as $key) {
            $data[$key] = $this->$key;
        }

        return $data;
    }

    protected function isValidImage($image, & $errorMsg = null)
    {
        getimagesizefromstring($image, $info);

        if (empty($info)) {
            $errorMsg = 'Avatar is not an image file';
        }

        return !empty($errorMsg);
    }

    public function authorize($request): bool
    {
        if ($this->password != encrypted($request->password)) {
            return false;
        }

        $sql = "
        UPDATE
            `{$this->getTable()}`
        SET
            last_auth = NOW(),
            auth_token = :token,
            lat = :lat,
            lon = :lon,
            country = :country
        WHERE
            user_id = :user_id
        ";

        $this->auth_token = $this->makeToken();

        pdo_st($sql, [
            'token' => $this->auth_token,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'country' => $request->country,
            'user_id' => $this->user_id,
        ]);

        return true;
    }

    protected function makeToken()
    {
        return encrypted($this->user_id . $this->password . 's3cr3tphr4se');
    }
}
