<?php


namespace fize\provider\sms\handler;

use RuntimeException;
use AlibabaCloud\Client\AlibabaCloud;
use fize\crypt\Json;
use fize\provider\sms\SmsHandler;

/**
 * 阿里云
 */
class AliYun implements SmsHandler
{

    /**
     * 阿里云配置
     * @var array
     */
    private $config;

    /**
     * 构造，初始化配置
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        AlibabaCloud::accessKeyClient($this->config['app_key'], $this->config['app_secret'])
            ->regionId('cn-hangzhou')
            ->asGlobalClient();
    }

    /**
     * 发送短信
     * @param string $phone_number 接收号码
     * @param string $template_code 短信模板ID
     * @param array $template_param 参数数组
     */
    public function send($phone_number, $template_code, $template_param = null)
    {
        $query = [
            'PhoneNumbers' => $phone_number,
            'SignName'     => $this->config['sign_name'],
            'TemplateCode' => $template_code
        ];
        if ($template_param) {
            $query['TemplateParam'] = Json::encode($template_param);
        }

        $response = AlibabaCloud::rpcRequest()
            ->product('Dysmsapi')
            ->scheme($this->config['scheme'])
            ->version('2017-05-25')
            ->action('SendSms')
            ->method('POST')
            ->options([
                'query' => $query,
            ])
            ->request();

        $response = $response->toArray();

        if (!isset($response['Code']) || $response['Code'] != 'OK') {
            throw new RuntimeException($response['Message'], $response['Code']);
        }
    }
}
