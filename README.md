
Yii2 阿里云短信服务接口

安装方法： composer require sharetrip/alisms

使用方法：

 objSms = new Sms( 

	Yii::objSms = new Sms( Yii::app->params['ALiSMS'] 

); 

$config = [ 'PhoneNumbers' => "12345678912", //Yii2 阿里云短信服务接口

安装方法： composer require sharetrip/alisms

使用方法： 

objSms = new Sms( Yii::app->params['ALiSMS'] ); 

$config = [ 

	'PhoneNumbers' => "12345678912", //手机号码

	 'SignName' => "分享之旅", //模板签名

	 'TemplateCode' => "SMS_**", //短信模板

	Code 'number' => "16888", //验证码

	'serialNumber' => time() //流水号 

];

 return objSms->sendSms( config );

