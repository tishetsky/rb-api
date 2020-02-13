<?php


namespace App;


class Request extends \Klein\Request
{
    public function __construct(array $params_get = array(), array $params_post = array(), array $cookies = array(), array $server = array(), array $files = array(), $body = null)
    {
        parent::__construct($params_get, $params_post, $cookies, $server, $files, $body);

        $this->body();

        if (!$data = json_decode($this->body)) {
            return;
        }

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
