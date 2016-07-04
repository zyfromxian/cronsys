<?php
namespace Home\Model;
use Think\Model;

class RunRecordModel extends Model{
        
        protected $connection = array(
        'db_type'               => 'mysql',
        'db_user'               => 'root',
        'db_pwd'                => '',
        'db_host'               => '127.0.0.1',
        'db_port'               => '3306',
        'db_name'               => 'cron',
        'db_charset'            => 'utf8',
        );

        protected $tableName = 'run_record';
}
?>