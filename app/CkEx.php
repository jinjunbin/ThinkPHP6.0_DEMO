<?php

namespace app;

use ClickHouseDB;
use think\facade\Config;

class CkEx
{
    private static $instance;
    private $config;
    private $ck;

    /**
     * 构造函数，设置配置
     */
    private function __construct()
    {
        $this->config = Config::get('database.connections.clickhouse');
    }

    /**
     * 获取单例实例
     *
     * @return static
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 删除单例实例
     */
    public static function delInstance()
    {
        if (self::$instance) {
            self::$instance = null;
        }
    }

    /**
     * 获取ck实例
     * @return Redis
     */
    public function getCk()
    {
        if (!$this->ck) {
            $this->ck = new ClickHouseDB\Client($this->config);
            //切换库
            //$this->ck->database($this->config['database']);
        }
        return $this->ck;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        if ($this->Ck) {
            $this->Ck = null;
        }
    }


    /**
     * 魔术方法，调用redis方法
     *
     * @param type $name
     * @param type $arguments
     *
     * @return boolean
     */
    public function __call($name, $arguments)
    {
        $ck = $this->getCk();
        return call_user_func_array(array(&$ck, $name), $arguments);
    }
}
