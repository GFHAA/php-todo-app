<?php
$conn = new PDO('mysql:host=localhost;dbname=todo', "mysql", "");
class Db
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function select($columns, $table, $where = [], $order = [])
    {
        $sql = "SELECT " . implode(',', $columns) . " FROM " . $table;
        if (!empty($where)) {
            $where_str = [];
            foreach ($where as $key => $value) {
                $where_str[] = "$key = ?";
            }
            $sql .= " WHERE " . implode(' AND ', $where_str);
        }
        if (!empty($order)) {
            $order_str = [];
            foreach ($order as $col => $dir) {
                $order_str[] = "$col $dir";
            }
            $sql .= " ORDER BY " . implode(', ', $order_str);
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($where)) {
            $i = 1;
            foreach ($where as $value) {
                $stmt->bindValue($i, $value);
                $i++;
            }
        }
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
$db = new Db($conn);
