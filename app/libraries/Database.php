<?php
class Database {
    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        // Set DSN
        $dsn = 'sqlite:' . dirname(dirname(__DIR__)) . '/database/travel_site.db';
        
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        );

        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, null, null, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Database Connection Error: " . $this->error);
            throw new Exception("Database connection failed. Please try again later.");
        }
    }

    // Prepare statement with query
    public function query($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Query Preparation Error: " . $this->error);
            throw new Exception("Query preparation failed.");
        }
    }

    // Bind values
    public function bind($param, $value, $type = null) {
        try {
            if(is_null($type)) {
                switch(true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Parameter Binding Error: " . $this->error);
            throw new Exception("Parameter binding failed.");
        }
    }

    // Execute the prepared statement
    public function execute() {
        try {
            $result = $this->stmt->execute();
            if (!$result) {
                $error = $this->stmt->errorInfo();
                error_log("Query Execution Error: " . print_r($error, true));
                throw new Exception("Query execution failed: " . $error[2]);
            }
            return $result;
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Query Execution Error: " . $this->error);
            throw new Exception("Query execution failed: " . $this->error);
        }
    }

    // Get result set as array of objects
    public function resultSet() {
        try {
            $this->execute();
            return $this->stmt->fetchAll();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Result Set Error: " . $this->error);
            throw new Exception("Failed to fetch results.");
        }
    }

    // Get single record as object
    public function single() {
        try {
            $this->execute();
            return $this->stmt->fetch();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Single Record Error: " . $this->error);
            throw new Exception("Failed to fetch single record.");
        }
    }

    // Get row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Get last inserted ID
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    // Begin transaction
    public function beginTransaction() {
        try {
            return $this->dbh->beginTransaction();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Begin Transaction Error: " . $this->error);
            throw new Exception("Failed to begin transaction: " . $this->error);
        }
    }

    // Commit transaction
    public function commit() {
        try {
            return $this->dbh->commit();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Commit Transaction Error: " . $this->error);
            throw new Exception("Failed to commit transaction: " . $this->error);
        }
    }

    // Rollback transaction
    public function rollBack() {
        try {
            return $this->dbh->rollBack();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Rollback Transaction Error: " . $this->error);
            throw new Exception("Failed to rollback transaction: " . $this->error);
        }
    }

    // Get error message
    public function getError() {
        return $this->error;
    }

    // Debug dump parameters
    public function debugDumpParams() {
        return $this->stmt->debugDumpParams();
    }

    // Get column names from a table
    public function getColumns($table) {
        try {
            $this->query("PRAGMA table_info(" . $table . ")");
            $this->execute();
            return $this->resultSet();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Get Columns Error: " . $this->error);
            return [];
        }
    }

    // Check if table exists
    public function tableExists($table) {
        try {
            $this->query("SELECT name FROM sqlite_master WHERE type='table' AND name=:table");
            $this->bind(':table', $table);
            $this->execute();
            return $this->rowCount() > 0;
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Table Exists Check Error: " . $this->error);
            return false;
        }
    }

    // Get all tables
    public function getTables() {
        try {
            $this->query("SELECT name FROM sqlite_master WHERE type='table'");
            $this->execute();
            return $this->resultSet();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Get Tables Error: " . $this->error);
            return [];
        }
    }
} 