<?php
/**
 * Файл MysqlProvider.php
 */

/**
 *
 * Класс-провайдер соединения с БД MySQL.
 *
 * @author  Sergey Cheryachukin <my_email@test.com>
 */
class MysqlProvider implements IDbProvider {

    /** @var PDO Экзкмпляр соединения с БД */
    private $_pdo;

    /** @var  string Строка запроса */
    private $_sql;

    /** @var  PDOStatement  PDOStatement */
    private $_stm;

    /**
     * MysqlProvider constructor.
     *
     * @param string $dsn
     * @param null   $user
     * @param null   $pass
     * @param null   $options
     */
    public function __construct($dsn, $user = null, $pass = null, $options = null) {
        $this->_pdo = new PDO($dsn, $user, $pass, $options);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $sql
     *
     * @return $this
     */
    public function createCommand($sql) {
        $this->_sql = $sql;
        $this->_stm = $this->_pdo->prepare($sql);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $params
     *
     * @return array|int
     */
    public function execute($params = []) {
        if (!is_array($params)) {
            $params = [$params];
        }

        if (!empty($params)) {
            return $this->queryAll($params);
        }

        return $this->_pdo->exec($this->_sql);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $table
     * @param array  $data
     *
     * @return bool
     */
    public function insert($table, array $data) {
        $fields = array_keys($data);
        $values = array_values($data);
        $places = array_fill(0, count($values), '?');
        $sql = "INSERT INTO $table (" . implode(',', $fields) . ") VALUES (" . implode(',', $places) . ")";

        $stm = $this->_pdo->prepare($sql);

        return $stm->execute($values);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $params
     *
     * @return array
     */
    public function queryAll(array $params = []) {
        if ($params !== []) {
            foreach ($params as $key => $value) {
                $this->_stm->bindValue($key, $value);
            }
        }
        $this->_stm->execute();

        return $this->_stm->fetchAll(PDO::FETCH_ASSOC);
    }
}