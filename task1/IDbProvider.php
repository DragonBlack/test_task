<?php
/**
 * File IDbProvider.php
 */

/**
 * Интерфейс соединения с БД.
 *
 * @author  Sergey Cheryachukin <my_email@test.com>
 */
interface IDbProvider {

    /**
     * Подготовка SQL-запроса
     *
     * @param string $sql
     *
     * @return self
     */
    public function createCommand($sql);

    /**
     * Выполнение подготовленного запроса
     *
     * @param array $params Массив параметров для подстановки
     *
     * @return int
     */
    public function execute($params = []);

    /**
     * Вставка строки данных в таблицу
     *
     * @param string $table Имя таблицы
     * @param array  $data  Ассоциативный массив с данными
     *
     * @return bool
     */
    public function insert($table, array $data);

    /**
     * Выполнение SELECT запроса и возврат всех записей выборки
     *
     * @param array $params Массив параметров для подстановки
     *
     * @return array
     */
    public function queryAll(array $params);
}