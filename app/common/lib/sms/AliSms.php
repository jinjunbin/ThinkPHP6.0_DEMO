<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/16
 * Time: 16:29
 */
declare(strict_types=1);
namespace app\common\lib\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use think\facade\Log;

class AliSms implements SmsBase
{
    /**
     * 阿里云发送短信验证码的场景
     * @param string $phone
     * @param int $code
     * @return bool
     * @throws ClientException
     */
    public static function sendCode(string $phone, int $code) : bool
    {
        if (empty($phone) || empty($code)) {
            return false;
        }

        // Download：https://github.com/aliyun/openapi-sdk-php
        // Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

        AlibabaCloud::accessKeyClient(config('aliyun.access_key_id'), config('aliyun.access_key_secret'))
            ->regionId(config('aliyun.region_id'))
            ->asDefaultClient();

        $templateParam = [
            'code' => $code,
        ];
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config('aliyun.host'))
                ->options([
                    'query' => [
                        'RegionId' => config('aliyun.region_id'),
                        'PhoneNumbers' => $phone,
                        'SignName' => config('aliyun.sign_name'),
                        'TemplateCode' => config('aliyun.template_code'),
                        'TemplateParam' =>json_encode($templateParam),
                    ],
                ])
                ->request();
            Log::info("alisms-sendCode-result-{$phone}".json_encode($result->toArray()));
            //print_r($result->toArray());
        } catch (ClientException $e) {
            Log::error("alisms-sendCode-ClientException-{$phone}".$e->getMessage());
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            Log::error("alisms-sendCode-ServerException-{$phone}".$e->getMessage());
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        }

        if (isset($result['Code']) && $result['Code'] == 'OK') {
            return true;
        }
        return false;
    }
}
