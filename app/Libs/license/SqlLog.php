<?php
namespace App\Libs\license;

class SqlLog
{
    // SQL语句
    private static $sql = [];

    // UPDATE 正则条件
    private static $updateExpression = '/UPDATE[\\s`]+?(\\w+)[\\s`]+?/is';

    // INSERT 正则条件
    private static $insertExpression = '/INSERT\\s+?INTO[\\s`]+?(\\w+)[\\s`]+?/is';

    // DELETE 正则条件
    private static $deleteExpression = '/DELETE\\s+?FROM[\\s`]+?(\\w+)[\\s`]+?/is';

    // SELECT 正则条件
    private static $selectExpression = '/((SELECT.+?FROM)|(Table structure for)|(LEFT\\s+JOIN|JOIN|LEFT))[\\s`]+?(\\w+)[\\s`]+?/is';


    private static $importExpression = '/((Table structure for))[\\s`]+?(\\w+)[\\s`]+?/is';
    /**
     * @return array 返回 导入SQL文件中 操作的所有表名
     */
    public static function importTableNames()
    {
        return self::getTableNames(self::$importExpression);
    }

    /**
     * @return array 返回查询操作的所有表名
     */
    public static function selectTableNames()
    {
        return self::getTableNames(self::$selectExpression);
    }

    /**
     * @return array 返回更新操作的所有表名
     */
    public static function updateTableNames()
    {
        return self::getTableNames(self::$updateExpression);
    }

    /**
     * @return array 返回插入操作的所有表名
     */
    public static function insertTableNames()
    {
        return self::getTableNames(self::$insertExpression);
    }

    /**
     * @return array 返回删除操作的所有表名
     */
    public static function deleteTableNames()
    {
        return self::getTableNames(self::$deleteExpression);
    }

    /**
     * 根据正则表达式获取所有操作的表名
     * @param $expression
     * @return array
     */
    public static function getTableNames($expression)
    {
        $sqlString = implode(PHP_EOL, self::$sql);
        preg_match_all($expression, $sqlString, $matches);

        return array_unique(array_pop($matches));
    }

    /**
     * 根据sql获取表名、操作
     * @param $sql string SQL语句
     */
    public static function setSql($sql)
    {
        self::$sql[] = $sql;
    }

    /**
     * 获取SQL语句
     * @return array SQL语句集合
     */
    public static function getSql()
    {
        return self::$sql;
    }
}