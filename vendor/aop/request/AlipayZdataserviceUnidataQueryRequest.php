<?php
/**
 * ALIPAY API: alipay.zdataservice.unidata.query request
 *
 * @author auto create
 * @since 1.0, 2019-03-08 15:29:11
 */
class AlipayZdataserviceUnidataQueryRequest
<<<<<<< HEAD
{
	/** 
	 * 通用的查询入参
	 **/
	private $queryCondition;
	
	/** 
	 * 返回数据的类型，内部业务系统分配
	 **/
=======
{
	/** 
	 * 通用的查询入参
	 **/
	private $queryCondition;
	
	/** 
	 * 返回数据的类型，内部业务系统分配
	 **/
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
	private $uniqKey;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	private $notifyUrl;
	private $returnUrl;
    private $needEncrypt=false;

<<<<<<< HEAD
	
	public function setQueryCondition($queryCondition)
	{
		$this->queryCondition = $queryCondition;
		$this->apiParas["query_condition"] = $queryCondition;
	}

	public function getQueryCondition()
	{
		return $this->queryCondition;
	}

	public function setUniqKey($uniqKey)
	{
		$this->uniqKey = $uniqKey;
		$this->apiParas["uniq_key"] = $uniqKey;
	}

	public function getUniqKey()
	{
		return $this->uniqKey;
=======
	
	public function setQueryCondition($queryCondition)
	{
		$this->queryCondition = $queryCondition;
		$this->apiParas["query_condition"] = $queryCondition;
	}

	public function getQueryCondition()
	{
		return $this->queryCondition;
	}

	public function setUniqKey($uniqKey)
	{
		$this->uniqKey = $uniqKey;
		$this->apiParas["uniq_key"] = $uniqKey;
	}

	public function getUniqKey()
	{
		return $this->uniqKey;
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
	}

	public function getApiMethodName()
	{
		return "alipay.zdataservice.unidata.query";
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
