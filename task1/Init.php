<?php
/**
 * Файл Init.php
 */

/**
 * Класс инициализации базы данных.
 *
 * @author  Sergey Cheryachukin <my_email@test.com>
 */
final class Init {

    /** @var MysqlProvider  Провайдер соединения с БД */
    private $_provider;

    /**
     * Init constructor.
     *
     * @param IDbProvider $provider
     */
    public function __construct(IDbProvider $provider) {
        $this->_provider = $provider;
        $this->create();
        $this->fill();
    }

    /**
     * Возвращает результат выборки.
     *
     * @return array    Ассоциативный массив результата выборки
     */
    public function get() {
        $sql = "SELECT id, script_name, start_time, end_time, result 
                FROM test 
                WHERE result = :r1 OR result = :r2";

        return $this->_provider->createCommand($sql)
            ->queryAll([
                ':r1' => 'normal',
                ':r2' => 'success',
            ]);
    }

    /**
     * Создает таблицу, если она еще не существует.
     */
    private function create() {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS test (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  script_name VARCHAR(25),
  start_time int(10),
  end_time int(10),
  result enum('normal', 'illegal', 'failed', 'success'),
  INDEX test_result_idx (result)
)ENGINE=InnoDB DEFAULT CHARSET=UTF8
SQL;
        $this->_provider->createCommand($sql)
            ->execute();

    }

    /**
     * Заполняет таблицу случайными данными.
     */
    private function fill() {
        for ($i = 0; $i < 1000; $i++) {
            $start_time = rand(946677600, time() - 3600);
            $row = [
                'script_name' => 'test' . rand(1, $i),
                'start_time' => $start_time,
                'end_time' => rand($start_time, time()),
                'result' => rand(1, 4)
            ];
            $this->_provider->insert('test', $row);
        }
    }
}