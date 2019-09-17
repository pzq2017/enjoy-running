<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/6
 * Time: 20:21
 */

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsSingleSender;

class SmsService
{
    private $appId;
    private $appSecret;

    const SMS_LOG = 'sms_log';
    const NATION_CODE = '86';

    public function __construct($app_id = null, $app_secret = null)
    {
        $this->appId = $app_id ?? config('sms.app_id');
        $this->appSecret = $app_secret ?? config('sms.app_key');
    }

    public function smsSingleSend($phoneNumber, $sendContent = null, $templateId = null, $templateParams = [])
    {
        try {
            $sms = new SmsSingleSender($this->appId, $this->appSecret);
            if (is_null($templateId)) {
                $result = $sms->send(0, self::NATION_CODE, $phoneNumber, $sendContent);
            } else {
                $result = $sms->sendWithParam(self::NATION_CODE, $phoneNumber, $templateId, $templateParams);
            }
            $result = json_decode($result, true);
            if ($result['result'] == 0) {
                return true;
            } else {
                Log::error(self::SMS_LOG.'=>'.$result['errmsg']);
            }
        } catch (\Exception $e) {
            Log::error(self::SMS_LOG.'=>'.$e->getMessage());
        }
        return false;
    }

    public function smsMultiSend($phoneNumbers, $templateId = null, $sendContent = null, $templateParams = [])
    {
        try {
            $sms = new SmsMultiSender($this->appId, $this->appSecret);
            if (is_null($templateId)) {
                $result = $sms->send(0, self::NATION_CODE, $phoneNumbers, $sendContent);
            } else {
                $result = $sms->sendWithParam(self::NATION_CODE, $phoneNumbers, $templateId, $templateParams);
            }
            return json_decode($result);
        } catch (\Exception $e) {
            Log::error(self::SMS_LOG.'=>'.$e->getMessage());
        }
    }
}