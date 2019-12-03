<?php
/**
 * ALIPAY API: alipay.offline.material.image.download request
 *
 * @author auto create
 * @since 1.0, 2019-03-08 15:29:11
 */
class AlipayOfflineMaterialImageDownloadRequest
<<<<<<< HEAD
{
	/** 
	 * 图片id列表
	 **/
=======
{
	/** 
	 * 图片id列表
	 **/
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
	private $imageIds;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	private $notifyUrl;
	private $returnUrl;
    private $needEncrypt=false;

<<<<<<< HEAD
	
	public function setImageIds($imageIds)
	{
		$this->imageIds = $imageIds;
		$this->apiParas["image_ids"] = $imageIds;
	}

	public function getImageIds()
	{
		return $this->imageIds;
=======
	
	public function setImageIds($imageIds)
	{
		$this->imageIds = $imageIds;
		$this->apiParas["image_ids"] = $imageIds;
	}

	public function getImageIds()
	{
		return $this->imageIds;
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
	}

	public function getApiMethodName()
	{
		return "alipay.offline.material.image.download";
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
