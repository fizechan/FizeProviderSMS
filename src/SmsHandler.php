<?php


namespace fize\provider\sms;

/**
 * 接口：短信
 */
interface SmsHandler
{
    /**
     * 发送短信
     * @param string $phone_number 接收号码
     * @param string $template_code 短信模板ID
     * @param array $template_param 参数数组
     */
    public function send($phone_number, $template_code, $template_param = null);
}
