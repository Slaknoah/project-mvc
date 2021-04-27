<?php


namespace app\core;


use app\core\exception\NotFoundException;

/**
 * Class DBModel
 * @package app\core
 */
abstract class DBModel extends Model
{
    public static int $per_page = 10;

    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName  = $this->tableName();
        $attributes = $this->attributes();
        $params     = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
            VALUES (".implode(',', $params).")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute} );
        }

        $statement->execute();

        return true;
    }

    public function update()
    {
        $tableName      = $this->tableName();
        $primaryKey     = static::primaryKey();
        $primaryKeyVal  = $this->{$primaryKey};
        $attributes     = $this->attributes();
        $newValSQL      = implode(",", array_map(fn($attr) => "$attr = :$attr", $attributes) );
        $statement      = self::prepare("UPDATE $tableName SET $newValSQL WHERE $primaryKey = $primaryKeyVal");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute} );
        }

        $statement->execute();

        return true;
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes) );
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    
    public static function paginate(array $where = [], array $orderBy = [])
    {
        $tableName  = static::tableName();
        $request    = Application::$app->request->getBody();
        $page       = intval( $request['page'] ?? 1 );
        $offset     = ( $page - 1 ) * static::$per_page;
        $total      = Application::$app->db->pdo->query("SELECT COUNT(*) from $tableName")->fetchColumn();
        $totalPages = ceil($total / static::$per_page );
        if( $page <= $totalPages ) {
            $result     = self::findAll($where, $orderBy, $offset);
        } else {
            throw new NotFoundException();
        }

        return [
            'data'  => $result,
            'total' => $total,
            'current_page' => $page,
            'total_pages'   => $totalPages
        ];
    }

    public static function findAll(array $where = [], array $orderBy = [], int $offset = 0)
    {
        $tableName = static::tableName();
        $orderByColumn = $orderBy[0] ?? static::primaryKey();
        $orderByDir = $orderBy[1] ?? 'DESC';
        $orderBySQL= "$orderByColumn $orderByDir";
        $limitSQL = ":offset, :per_page";
        if( count($where) > 0 ) {
            $attributes = array_keys($where);
            $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes) );
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql ORDER BY $orderBySQL LIMIT $limitSQL");

            foreach ($where as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
        } else {
            $statement = self::prepare("SELECT * FROM $tableName ORDER BY $orderBySQL LIMIT $limitSQL");
        }

        $statement->bindValue(":offset", $offset, Application::$app->db->pdo::PARAM_INT);
        $statement->bindValue(":per_page", static::$per_page, Application::$app->db->pdo::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll(Application::$app->db->pdo::FETCH_CLASS, static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}