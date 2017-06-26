<?php
/* Create a class for your webservice structure, AllMySms */
class AllMySms {
	
	/* parameters for the request */
	public $params = array();
	public $clientSoap;
	
	public function __construct($login, $passwd) {
		$this->params = array(
				"clientCode" => $login,
				"passCode"   => $passwd,
		);
		
		/* Initialize webservice with your WSDL */
		$this->clientSoap = new SoapClient("http://api.msinnovations.com/soap/wsdl.php");
	}
	
	public function getInfo()
	{
		/* Invoke webservice method with your parameters, in this case: getInfo */
		return $this->clientSoap->__soapCall("getInfo", $this->params);
	}

	public function sendSms($messageData)
	{
		$this->params[] = $messageData;
		/* Invoke webservice method with your parameters, in this case: sendSms */
		return $this->clientSoap->__soapCall("sendSms", $this->params);
	}
}

/* Fill your AllMySms Object */
$allmysms = new AllMySms("jaffaya", "zanzarah1");

//get information about your account
$response = $allmysms->getInfo();
var_dump($response);

//sending sms
//create a sms object (cf: documentation)
$messageData = new stdClass();
$messageData->message = "Krutyack!";
$messageData->campaignName = "soap campaign"; //"QQQ";
$messageData->sms->item[0]->mobilePhone = "380987273656";//я
$messageData->sms->item[1]->mobilePhone = "380966016788";//Мама
$messageData->sms->item[2]->mobilePhone = "380687390550";//Олег
$messageData->sms->item[3]->mobilePhone = "380961566899";//Аня
$messageData->sms->item[3]->mobilePhone = "380975105895";//Папа

//send sms
$response = $allmysms->sendSms($messageData);

/* var dump webservice response */
var_dump($response);
