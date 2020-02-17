<?php

namespace fize\provider\sms;

/**
 * 短信
 */
class Sms
{
    /**
     * @var SmsHandler
     */
    private static $handler;

    /**
     * 取得单例
     * @param string $handler 使用的实际接口名称
     * @param array $config 接口参数
     * @return SmsHandler
     */
    public static function getInstance($handler, array $config = null)
    {
        if (empty(self::$handler)) {
            $class = '\\' . __NAMESPACE__ . '\\handler\\' . $handler;
            self::$handler = new $class($config);
        }
        return self::$handler;
    }
}
