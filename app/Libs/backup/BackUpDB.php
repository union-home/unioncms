<?php
namespace App\Libs\backup;

use Illuminate\Support\Facades\DB;
use Mockery\Exception;

/**
 * mysql数据库完整备份、备份数据库中指定表
 */
class BackUpDB
{
    /**
     * @var stores the options
     */
    var $config;

    /**
     * @var stores the final sql dump
     */
    var $dump;

    /**
     * @var stores the table structure + inserts for every table
     */
    var $struktur = array();

    /**
     * @var zip file name
     */
    var $filename;

    /**
     * this function is the constructor and phrase the options
     * and connect to the database
     * @return
     */
    public function __construct()
    {

    }

    /**
     * this function start the backup progress its the core function
     * @return
     */
    public function backupDB($post)
    {
        // start backup
        if(isset($post['form']) && $post['form']=="backup")
        {
            // check if tables are selected
            if(empty($post['table']))
            {
                throw new \Exception("Please select a table.",40000);
            }

            /** start backup **/
            $tables = array();
            $insert = array();
            $sql_statement = '';

            // lock tables
            foreach($post['table'] AS $table)
            {
                // Read table structure
                $res = DB::select('SHOW CREATE TABLE '.$table.'');
                $res = json_decode(json_encode($res[0]),true);

                $str = PHP_EOL."DROP TABLE IF EXISTS `$table`;".PHP_EOL.$res["Create Table"].";".PHP_EOL.PHP_EOL;

                array_push($tables, $str);

                // Read table "inserts"
                $sql = 'SELECT * FROM '.$table;

                $res = DB::select($sql);

                $sql_statement = PHP_EOL.PHP_EOL."---- Data Table `$table` --".PHP_EOL.PHP_EOL;

                // start reading progress
                foreach ($res as $val){
                    $sql_statement .= 'INSERT INTO `'.$table.'` (';

                    $vars = get_object_vars($val);

                    foreach ($vars as $k => $v) {
                        $sql_statement .= "`".$k."`,";
                    }

                    $sql_statement = rtrim($sql_statement,",");


                    $sql_statement .= ') VALUES (';

                    foreach ($vars as $k => $v) {

                        if(gettype($v)=="string"){
                            $sql_statement .= "'".$v."',";
                        }else if(gettype($v)=="NULL"){
                            $sql_statement .= gettype($v).",";
                        }else{
                            $sql_statement .= $v.",";
                        }

                    }

                    $sql_statement = rtrim($sql_statement,",");

                    $sql_statement .= ");".PHP_EOL;
                }

                // insert "Inserts" into an array if not exists
                if(!in_array($sql_statement, $insert))
                {
                    array_push($insert, $sql_statement);
                    unset($sql_statement);
                }

                unset($sql_statement);

            }

            // put table structure and inserts together in one var
            $this->struktur = array_combine($tables, $insert);

            // create full dump
            $this->createDUMP($this->struktur);

            // create zip file
            $this->createZIP();

            /** end backup **/
            return true;
        }
    }

    /**
     * this function create the zip file with the database dump and save it on the ftp server
     * @return
     */
    protected function createZIP()
    {

        // Set permissions to 777
        $basedir = base_path()."/backup/";

        if(!is_dir($basedir)){
            mkdir($basedir);
        }

        chmod($basedir, 0777);


        // create zip file
        //$zip = new \ZipArchive();
        // Create file name
        $this->filename = $basedir.env("DB_DATABASE")."-".date("YmdH_i_s").".sql";

        // Checking if file could be created
        /*if ($zip->open($this->filename, ZIPARCHIVE::CREATE)!==TRUE) {
            throw new \Exception("cannot open <".$this->filename.">\n");
        }

        // add mysql dump to zip file
        $zip->addFromString("dump.sql", $this->dump);
        // close file
        $zip->close();*/
        file_put_contents($this->filename,$this->dump);
        // Check whether file has been created
        if(!file_exists($this->filename))
        {
            throw new \Exception("The sql file could not be created.");
        }

    }

    /**
     * this function create the full sql dump
     * @param object $dump
     * @return
     */
    protected function createDUMP($dump)
    {
        $date = date("Y-m-d H:i:s");
        $database = env("DB_DATABASE");
        $header = <<<HEADER
-- SQL Dump
--
-- Host: {$_SERVER['HTTP_HOST']}
-- Erstellungszeit: {$date}

--
-- Datenbank:  {$database}
--
-- --------------------------------------------------------
HEADER;

        $sql = "";

        foreach($dump AS $name => $value)
        {
            $sql .= $name.$value;
        }
        $this->dump = $header.$sql;
    }



    //导入数据sql
    function ImportSql($filename){
        if(file_exists($filename)){
             $data = file($filename);

             $tmp=array();
             foreach ($data as $line) {

                 $line=trim($line);
                 if(strlen($line)==0){
                     continue;
                 }
                 if(substr($line,0,2)=='--'){
                     continue;
                 }
                 if(substr($line,0,2)=='/*'){
                     continue;
                 }
                 $tmp[]=$line;

                 if(substr($line,-1)==';'){
                     $query=implode('',$tmp);
                     $tmp=array();
                     DB::select("set names utf8");
                     try{

                         DB::select($query);

                     }catch (Exception $exception){

                     }
                 }

             }





        }else{
            throw new \Exception("The sql file does not exist.");
        }
    }

}


?>
