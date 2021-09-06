<?php

/**
 * 数据库备份与还原请求接口
 */

class backup {

    private $host = '';
    private $user = '';
    private $name = '';
    private $pass = '';
    private $port = '';
    private $tables = ['*'];
    private $ignoreTables = [];
    private $db;
    private $ds = "\n";

    public function __construct($host = null, $user = null, $name = null, $pass = null, $port = 3306) {
        if ($host !== null) {
            $this->host = $host;
            $this->name = $name;
            $this->port = $port;
            $this->pass = $pass;
            $this->user = $user;
        }
        $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name . '; port=' . $port, $this->user, $this->pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $this->db->exec('SET NAMES "utf8mb4"');
    }

    /**
     * 设置备份表
     * @param $table
     * @return $this
     */
    public function setTable($table) {
        if ($table) {
            $this->tables = is_array($table) ? $table : explode(',', $table);
        }
        return $this;
    }

    /**
     * 设置忽略备份的表
     * @param $table
     * @return $this
     */
    public function setIgnoreTable($table) {
        if ($table) {
            $this->ignoreTables = is_array($table) ? $table : explode(',', preg_replace('/\s+/', '', $table));
        }
        return $this;
    }

    public function backup($backUpdir = CACHE_PATH.'bakup/default/') {
        $sql = $this->_init();
        $zip = new ZipArchive();
        $date = date('YmdHis');
        if (!is_dir($backUpdir)) {
            @mkdir($backUpdir, 0755);
        }
        $name = "backup-{$this->name}-{$date}";
        $filename = $backUpdir . $name . ".zip";

        if ($zip->open($filename, ZIPARCHIVE::CREATE) !== true) {
            throw new Exception("Could not open <$filename>\n");
        }
        $zip->addFromString($name . ".sql", $sql);
        $zip->close();
    }

    private function _init() {
        # COUNT
        $ct = 0;
        # CONTENT
        $sqldump = '';
        # COPYRIGHT & OPTIONS
        $sqldump .= "-- SQL Dump by Erik Edgren\n";
        $sqldump .= "-- version 1.0\n";
        $sqldump .= "--\n";
        $sqldump .= "-- SQL Dump created: " . date('F jS, Y \@ g:i a') . "\n\n";
        $sqldump .= "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n";
        $tables = $this->db->query("SHOW FULL TABLES WHERE Table_Type != 'VIEW'");
        # LOOP: Get the tables
        foreach ($tables AS $table) {
            // 忽略表
            if (in_array($table[0], $this->ignoreTables)) {
                continue;
            }
            # COUNT
            $ct++;
            /** ** ** ** ** **/
            # DATABASE: Count the rows in each tables
            $count_rows = $this->db->prepare("SELECT * FROM " . $table[0]);
            $count_rows->execute();
            $c_rows = $count_rows->columnCount();
            # DATABASE: Count the columns in each tables
            $count_columns = $this->db->prepare("SELECT COUNT(*) FROM " . $table[0]);
            $count_columns->execute();
            $c_columns = $count_columns->fetchColumn();
            /** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **/
            # MYSQL DUMP: Remove tables if they exists
            $sqldump .= "\n";
            $sqldump .= "--\n";
            $sqldump .= "-- Remove the table if it exists\n";
            $sqldump .= "--\n";
            $sqldump .= "DROP TABLE IF EXISTS `" . $table[0] . "`;\n\n";
            /** ** ** ** ** **/
            # MYSQL DUMP: Create table if they do not exists
            $sqldump .= "--\n";
            $sqldump .= "-- Create the table if it not exists\n";
            $sqldump .= "--\n";
            # LOOP: Get the fields for the table
            foreach ($this->db->query("SHOW CREATE TABLE " . $table[0]) AS $field) {
                $sqldump .= str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $field['Create Table']);
            }
            # MYSQL DUMP: New rows
            $sqldump .= ";\n";
            /** ** ** ** ** **/
            # CHECK: There are one or more columns
            if ($c_columns != 0) {
                # MYSQL DUMP: List the data for each table
                $sqldump .= "\n";
                $sqldump .= "--\n";
                $sqldump .= "-- List the data for the table\n";
                $sqldump .= "--\n";
                # COUNT
                $c = 0;
                # LOOP: Get the tables
                foreach ($this->db->query("SELECT * FROM " . $table[0]) AS $data) {
                    # COUNT
                    $c++;
                    /** ** ** ** ** **/
                    # MYSQL DUMP: Insert into each table
                    /*$sqldump .= "INSERT INTO `" . $table[0] . "` (";
                    # ARRAY
                    $rows = Array();
                    # LOOP: Get the tables
                    foreach ($this->db->query("DESCRIBE " . $table[0]) AS $row) {
                        $rows[] = "`" . $row[0] . "`";
                    }
                    $sqldump .= implode(', ', $rows);
                    $sqldump .= ") VALUES(";*/
                    $sqldump .= "INSERT INTO `" . $table[0] . "` VALUES(";
                    # ARRAY
                    $cdata = Array();
                    # LOOP
                    for ($i = 0; $i < $c_rows; $i++) {
                        if (is_null($data[$i])) {
                            $cdata[] = "null";
                        } else {
                            $new_lines = $this->escape($data[$i]);
                            $cdata[] = "'" . $new_lines . "'";
                        }
                    }
                    $sqldump .= implode(', ', $cdata);
                    $sqldump .= ");\n";
                }
            }
        }

        // Backup views
        $tables = $this->db->query("SHOW FULL TABLES WHERE Table_Type = 'VIEW'");
        # LOOP: Get the tables
        if (is_array($tables) && $tables) {
            $sqldump .= "\n\n\n";
            foreach ($tables AS $table) {
                // 忽略表
                if (in_array($table[0], $this->ignoreTables)) {
                    continue;
                }
                foreach ($this->db->query("SHOW CREATE VIEW " . $table[0]) AS $field) {
                    $sqldump .= "--\n";
                    $sqldump .= "-- Remove the view if it exists\n";
                    $sqldump .= "--\n\n";
                    $sqldump .= "DROP VIEW IF EXISTS `{$field[0]}`;\n\n";
                    $sqldump .= "--\n";
                    $sqldump .= "-- Create the view if it not exists\n";
                    $sqldump .= "--\n\n";
                    $sqldump .= "{$field[1]};\n\n";
                }
            }
        }
        if ($this->link) {
            $this->link->close();
        }
        $this->link = null;
        $sqldump = "/*\ncms bakfile\nversion:CMS V9\ntime:".date('Y-m-d H:i:s')."\ntype:cms\ncms:\n*/\n\nSET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS = 0;\n\n".$sqldump."\nSET FOREIGN_KEY_CHECKS = 1;\n";
        return $sqldump;

    }

    public function connect() {
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->name, $this->port);
        if(mysqli_connect_error()){
            return false;
        }
        if($this->version() > '4.1') {
            $charset = 'utf8mb4';
            $serverset = $charset ? "character_set_connection='$charset',character_set_results='$charset',character_set_client=binary" : '';
            $serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
            $serverset && $this->link->query("SET $serverset");
        }
        return $this->link;
    }

    public function version() {
        if(!is_object($this->link)) {
            $this->connect();
        }
        return $this->link->server_info;
    }

    public function escape($str){
        if(!is_object($this->link)) {
            $this->connect();
        }
        return $this->link->real_escape_string($str);
    }

}
