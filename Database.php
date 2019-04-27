<?php
class Database {

    private $dsnLocal = "mysql:dbname=Timlin1;host=localhost;port=3306";
    private $dsn = "mysql:dbname=vh3384_test;host=localhost;port=3306";
    private $dsnPost="pgsql:host=localhost;port=5432;dbname=postgres;user=postgres;password=test";

    private $usr = 'vh3384_testuser';
    private $pwd = "Test1234!";
    private $host = "localhost";
    private $dbh = null;
    private $stmt = null;
    private $os = "LIN";
    private $local = false;
    private $dbType=1;
    
    public function __construct($args = null) {
        // echo "db constructor";
        if ($this->local) {
            $this->dbh = new PDO($this->dsnLocal, "devuser", "Test1234");
        } else if ($this->dbType==2){
            //echo $this->dsnPost;
            $this->dbh = new PDO($this->dsnPost);
        }else{
            $this->dbh = new PDO($this->dsn, $this->usr, $this->pwd);
        }
        //$this->dbh = new PDO('pgsql:user=exampleuser dbname=exampledb password=examplepass');
    }

    public function json($sql, $arr = 1, $firstRow = "") {
        $stmt = $this->query($sql);
        if ($stmt->rowCount() == 0)
            return null;
        $idx = 0;
        $retval = ($arr == 1 ? "[" : "") . $firstRow;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retval .= ($idx == 0 ? "{" : "},{");
            $col = 0;
            foreach ($row as $value) {
                $meta = $stmt->getColumnMeta($col);
                $name = $meta['name'];
                $val = str_replace("\r\n", "@@crlf", $value);
                $retval .= ($col == 0 ? "" : ",") . "$name:\"$val\"";
                $col++;
            }
            $idx++;
        }
        if ($idx == 0)
            return ($arr == 1 ? "[{status: -1}]" : "{status: -1}");
        $retval .= ($arr == 1 ? "}]" : "}");
        return $retval;
    }

    public function execute($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
            //echo $sql;
            $retval = $this->stmt->execute(); //or die (implode(':', $this->stmt->errorInfo()));
            if (!($retval))
                return -1;

            if (substr(strtoupper($sql), 0, 1) != "I")
                return 1;

            $this->query("SELECT LAST_INSERT_ID()");
            $row = $this->fetch();
            return $row[0];
        } catch (PDOException $e) {
            echo "$sql failed reason: $e";
            return -2;
        }
    }

    public function call($sql) {
        return $this->query("call $sql");
    }

    public function query($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute();
            return $this->stmt;
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function fetch() {
        try {
            return $this->stmt->fetch();
        } catch (PDOException $e) {
            die('Fetch failed: ' . $e->getMessage());
        }
    }

    public function close() {
        $this->dbh = null;
        //mysql_close( $dbh );
    }

}

?>