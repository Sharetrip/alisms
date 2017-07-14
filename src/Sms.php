<?php
/**
 * Created by Stone chen
 * User: admin
 * Date: 2017/7/12
 * Time: 14:20
 */

namespace Sharetrip\Alisms;


use Dysmsapi\Request\V20170525\SendSmsRequest;
include 'aliyun-php-sdk-core/Config.php';
include_once 'Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once 'Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';

class Sms
{
    private $accessKeyId;
    private $accessKeySecret;

    public $error = "";

    public function __construct( $options )
    {
        if ( !$options['access_key_id'] ) {
            return "accessId , 为必填参数";
        }

        if ( !$options['access_key_secret'] ) {
            return "secret , 为必填参数";
        }
        $this->accessKeyId = $options['access_key_id'];
        $this->accessKeySecret = $options['access_key_secret'];
    }

    /**
     * 发送验证码
     * @param $sms_config
     * @return mixed|\SimpleXMLElement|void
     */
    public function sendSms( $sms_config =[] )
    {
        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = "cn-hangzhou";
        //初始化访问的acsCleint
        $profile = \DefaultProfile::getProfile($region, $this->accessKeyId,$this->accessKeySecret);
        \DefaultProfile::addEndpoint("cn-hangzhou","cn-hangzhou", $product, $domain);

        $acsClient = new \DefaultAcsClient( $profile );

        if ( !$sms_config['PhoneNumbers'] ) {
            $this->error = "短信接受号码--必须设置";
            return;
        }

        if ( !$sms_config['SignName'] ) {
            $this->error = "短信签名--必须设置";
            return;
        }

        if ( !$sms_config['TemplateCode'] ) {
            $this->error = "短信模板Code--必须设置";
            return;
        }

        if ( !$sms_config['number'] ) {
            $this->error = "模板变量--必须设置";
            return;
        }

        $request = new SendSmsRequest();

        //必填-短信接收号码
        $request->setPhoneNumbers($sms_config["PhoneNumbers"]);
        //必填-短信签名
        $request->setSignName($sms_config["SignName"]);
        //必填-短信模板Code
        $request->setTemplateCode($sms_config["TemplateCode"]);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        $request->setTemplateParam('{"number":"'.$sms_config["number"].'","product":"'.$sms_config["SignName"].'"}');
        //选填-发送短信流水号
        $request->setOutId($sms_config["serialNumber"]);

        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);

        return $acsResponse;

    }

	public function querySendDetails() {
    
    //此处需要替换成自己的AK信息
    $accessKeyId = "yourAccessKeyId";
    $accessKeySecret = "yourAccessKeySecret";
    //短信API产品名
    $product = "Dysmsapi";
    //短信API产品域名
    $domain = "dysmsapi.aliyuncs.com";
    //暂时不支持多Region
    $region = "cn-hangzhou";
    
    //初始化访问的acsCleint
    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
    $acsClient= new DefaultAcsClient($profile);
    
    $request = new Dysmsapi\Request\V20170525\QuerySendDetailsRequest();
    //必填-短信接收号码
    $request->setPhoneNumber("15000000000");
    //选填-短信发送流水号
    $request->setBizId("abcdefgh");
    //必填-短信发送日期，支持近30天记录查询，格式yyyyMMdd
    $request->setSendDate("20170525");
    //必填-分页大小
    $request->setPageSize(10);
    //必填-当前页码
    $request->setContent(1);
    
    //发起访问请求
    $acsResponse = $acsClient->getAcsResponse($request);
    var_dump($acsResponse);
    
}




}