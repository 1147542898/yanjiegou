<?php
/**
 * ALIPAY API: alipay.mobile.bksigntoken.verify request
 *
 * @author auto create
 * @since 1.0, 2019-03-08 15:29:11
 */
class AlipayMobileBksigntokenVerifyRequest
<<<<<<< HEAD
{
	/** 
	 * 设备标识
	 **/
	private $deviceid;
	
	/** 
	 * 调用来源
	 **/
	private $source;
	
	/** 
	 * 查询token
	 **/
=======
{
	/** 
	 * 设备标识
	 **/
	private $deviceid;
	
	/** 
	 * 调用来源
	 **/
	private $source;
	
	/** 
	 * 查询token
	 **/
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
	private $token;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	private $notifyUrl;
	private $returnUrl;
    private $needEncrypt=false;

<<<<<<< HEAD
	
	public function setDeviceid($deviceid)
	{
		$this->deviceid = $deviceid;
		$this->apiParas["deviceid"] = $deviceid;
	}

	public function getDeviceid()
	{
		return $this->deviceid;
	}

	public function setSource($source)
	{
		$this->source = $source;
		$this->apiParas["source"] = $source;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function setToken($token)
	{
		$this->token = $token;
		$this->apiParas["token"] = $token;
	}

	public function getToken()
	{
		return $this->token;
=======
	
	public function setDeviceid($deviceid)
	{
		$this->deviceid = $deviceid;
		$this->apiParas["deviceid"] = $deviceid;
	}

	public function getDeviceid()
	{
		return $this->deviceid;
	}

	public function setSource($source)
	{
		$this->source = $source;
		$this->apiParas["source"] = $source;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function setToken($token)
	{
		$this->token = $token;
		$this->apiParas["token"] = $token;
	}

	public function getToken()
	{
		return $this->token;
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
	}

	public function getApiMethodName()
	{
		return "alipay.mobile.bksigntoken.verify";
	}

	public function setNotifyUrl($notifyUrl)
	{
		$this->notifyUrl=$notifyUrl;
	}

	public function getNotifyUrl()
	{
		return $this->notifyUrl;
	}

	public function setReturnUrl($returnUrl)
	{
		$this->returnUrl=$returnUrl;
	}

	public function getReturnUrl()
	{
		return $this->returnUrl;
	}

	public function getApiParas()
	{
		return $this->apiParas;
	}

	public function getTerminalType()
	{
		return $this->terminalType;
	}

	public function setTerminalType($terminalType)
	{
		$this->terminalType = $terminalType;
	}

	public function getTerminalInfo()
	{
		return $this->terminalInfo;
	}

	public function setTerminalInfo($terminalInfo)
	{
		$this->terminalInfo = $terminalInfo;
	}

	public function getProdCode()
	{
		return $this->prodCode;
	}

	public function setProdCode($prodCode)
	{
		$this->prodCode = $prodCode;
	}

	public function setApiVersion($apiVersion)
	{
		$this->apiVersion=$apiVersion;
	}

	public function getApiVersion()
	{
		return $this->apiVersion;
	}

  public function setNeedEncrypt($needEncrypt)
  {

     $this->needEncrypt=$needEncrypt;

  }

  public function getNeedEncrypt()
  {
    return $this->needEncrypt;
  }

}
