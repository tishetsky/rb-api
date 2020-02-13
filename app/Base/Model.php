<?php


namespace App\Base;


class Model
{
    protected $table;
    protected $id;

    public function getTable()
    {
        return $this->table;
    }

    public static function find(string $value, string $column = 'username'): ?Model
    {
        $item = new static;
        $sql = "SELECT * FROM `{$item->getTable()}` WHERE `{$column}` = :value";
        $st = pdo_st($sql, [
            'value' => $value,
        ]);

        $data = $st->fetch(\PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return $item->load($data);
        }

        return null;
    }

    public function load(array $data = null): Model
    {
        if (empty($data) && !empty($this->id)) {
            $data = static::find($this->id, 'id');
        }

        if (empty($data)) {
            $class = get_class($this);
            throw new \Exception("Failed to load {$class}, id = {$this->id}");
        }

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }

        return null;
    }
}
