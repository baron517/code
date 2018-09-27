<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Api\Controller;
use Think\Controller;

header("Access-Control-Allow-Origin: *");

/**
 * 首页
 */
class CommonApiController extends Controller {

    private function curl_https($url, $data=array(), $header=array(), $timeout=30){

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

			$response = curl_exec($ch);

			if($error=curl_error($ch)){
				die($error);
			}

			curl_close($ch);

			return $response;

		}
	
	private function this_monday($timestamp=0,$is_return_timestamp=true){ 
            static $cache ; 
            $id = $timestamp.$is_return_timestamp; 
            if(!isset($cache[$id])){ 
                if(!$timestamp) $timestamp = time(); 
                $monday_date = date('Y-m-d', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400)); 
                if($is_return_timestamp){ 
                    $cache[$id] = strtotime($monday_date); 
                }else{ 
                    $cache[$id] = $monday_date; 
                } 
            } 
            return $cache[$id]; 
   
    } 
	

    public function getTagList()
	{
	    $Tag = M("Tag");
	    $list=$Tag->select();
	    echo json_encode($list);
	}
	

	
	public function appLogin()
	{
	    $Member = M("Member");
	    $data["phone"]=$_POST["phone"];
	    $data["password"]=$_POST["password"];
	    $list=[];
	    $list=$Member->where($data)->find();
	    
	    echo json_encode($list);
	}
	
	
	public function reg()
	{
	     $phone=$_POST["phone"];
	    
        $Msg_code = M("Msg_code");
     	$codeData=$Msg_code->where("phone='".$phone."'")->find();
	    
	   
	    
	    if($codeData["code"]!=$_POST["code"])
	    {
	        $res["code"]="-1";
	        $res["msg"]="验证码不正确";
	       
	        
	    }
	     else if($codeData["phone"]!=$_POST["phone"])
	    {
	        $res["code"]="-2";
	        $res["msg"]="验证码发送的不是这个手机";
	    }
	    else{
            	$User = M("Member");
            	$data["phone"]=$_POST["phone"];
            	
            	$findData["phone"]=$_POST["phone"];
            	$findRs=$User->where($data)->find();
            	if($findRs)
            	{
            	    
            	    $data1["password"]=$_POST["password"];
            	    $rs1=$User->where("phone='".$_POST["phone"]."'")->save($data1);
            	  
        	    	$res["code"]="1";
                    $res["msg"]="注册成功";
                
            	}
            	else{
            	    	$data["openid"]=$_POST["openid"];
            	        $data["create_time"]=date("Y-m-d H:i:s");
            	        $data["password"]=$_POST["password"];
            	    	$rs=$User->add($data);
                    	if($rs)
                    	{
                	    	$res["code"]="1";
	                        $res["msg"]="注册成功";
                    	}
                    	else{
                    	    $res["code"]="0";
	                        $res["msg"]="系统异常";
                    	}
            	}
            	
            
            
	    }
	    
	    echo json_encode($res);
	    
	}
	
	public function getDayStep()
	{
	    $Step_count=M("Step_count");
	    $data["timestamp"]=strtotime(date("Y-m-d")." 00:00:00");
	    $data["m_step_id"]=$_GET["m_id"];
	    
	    $list=$Step_count->where($data)->find();
	    
	    echo json_encode($list);
	    
	    
	}
	
	
	public function saveDayStep()
	{
	    
	    //sp_log("测试".$_GET["night_step"]);
	    
	    $Step_count=M("Step_count");
	    $data["timestamp"]=strtotime(date("Y-m-d")." 00:00:00");
	    $data["m_step_id"]=$_GET["m_id"];
	    $data["step"]=$_GET["step"];
	    $data["score"]=$_GET["score"];
	    $data["update_time"]=date("Y-m-d H:i:s");
	    $data["is_miniapp"]=0;
	    $data["system"]=1;
	    
	    $data["morning_step"]=$_GET["morning_step"];
	    $data["night_step"]=$_GET["night_step"];
	    
	    
        $data1["timestamp"]=strtotime(date("Y-m-d")." 00:00:00");
	    $data1["m_step_id"]=$_GET["m_id"];
	    
	    $rs=$Step_count->where($data1)->find();
	    
	    if($rs)
	    {
	       
	          $rs=$Step_count->where($data1)->save($data);  
	        
	        
	    }
	    else{
	        $rs=$Step_count->add($data);
	    }
	    
	    
	    echo $rs;
	    
	    
	}
	
	
	
	

	
	public function getUserInfo()
	{
		
		$accessTokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx2eb8f72e1c6add14&secret=19a6d3f5c894e74f3df6fabbf2d300a0";
		
		$data = array();
		$header = array();

		$response = $this->curl_https($accessTokenUrl, $data, $header, 5);

		$rsObj=json_decode($response);
		
		$accessToken=$rsObj->access_token;
		
		//sp_log($response);

        $openid=$_GET["openid"];
        
        $userInfoUrl="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$accessToken."&openid=".$openid;
        
    	$userInfoRp =  $this->curl_https($userInfoUrl, $data, $header, 5);
    	
    	echo $userInfoRp;
	}
	
	
	
	
	public function userInfoSave()
	{
	    $Member = M("Member");
	    $data["city"]=$_POST["city"];
	    $data["country"]=$_POST["country"];
	    $data["province"]=$_POST["province"];
	    $data["avatar"]=$_POST["avatarUrl"];
	    $data["nickname"]=$_POST["nickName"];
	    $data["gender"]=$_POST["gender"];
	    if($_POST["nickName"]!="undefined")
	    {
	       $rs=$Member->where("m_id='".$_POST["m_id"]."'")->save($data); 
	    }
		
		echo 1;
	}
	

	
	
	
	//判断是否绑定
	public function judgeBindInfo() {
	    
	    
	    $appid = $_POST["appid"];
        $appSecret=$_POST["secret"];
        $code=$_POST["code"];
	    
	    //sp_log($code);
	    
	    $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appSecret."&js_code=".$code."&grant_type=authorization_code";
	    
    	$data = array();
		$header = array();

		$response = $this->curl_https($url, $data, $header, 5);
		
		//sp_log($response);
		
		$rsObj=json_decode($response);
		
		
		$openid=$rsObj->unionid;
	
		
		 $Member = M("Member");
     	 $rs=$Member->where("unionid='".$openid."'")->find();
     	 
     	 
		 if($rs)
		 {
		    $rsObj->exist=1; 
		 }
		 else{
		     $rsObj->exist=0; 
		 }
		 
		 $rsObj->user_info=$rs;
		
		echo json_encode($rsObj);
	    
	   
	}
	


	
	public function bindPost()
	{
	    
	    $phone=$_POST["phone"];
	    
        $Msg_code = M("Msg_code");
     	$codeData=$Msg_code->where("phone='".$phone."'")->find();
	    
	   
	    
	    if($codeData["code"]!=$_POST["code"])
	    {
	        $res["code"]="-1";
	        $res["msg"]="验证码不正确";
	       
	        
	    }
	     else if($codeData["phone"]!=$_POST["phone"])
	    {
	        $res["code"]="-2";
	        $res["msg"]="验证码发送的不是这个手机";
	    }
	    else{
            	$User = M("Member");
            	$data["phone"]=$_POST["phone"];
            	
            	$findData["phone"]=$_POST["phone"];
            	$findRs=$User->where($findData)->find();
            	
            	
            	if($findRs>0)
            	{
            	    
            	    $data["x_openid"]=$_POST["openid"];
            	    $data["unionid"]=$_POST["unionid"];
        	        $data["create_time"]=date("Y-m-d H:i:s");
        	    	$rs=$User->where("phone='".$_POST["phone"]."'")->save($data);
            	    $res["code"]="1";
                    $res["msg"]="绑定成功";
            	}
            	else{
            	    	$data["x_openid"]=$_POST["openid"];
            	    	$data["unionid"]=$_POST["unionid"];
            	        $data["create_time"]=date("Y-m-d H:i:s");
            	    	$rs=$User->add($data);
                    	if($rs)
                    	{
                	    	$res["code"]="1";
	                        $res["msg"]="绑定成功";
                    	}
                    	else{
                    	    $res["code"]="0";
	                        $res["msg"]="系统异常";
                    	}
            	}
            	
            
            
	    }
	    
	    echo json_encode($res);
	    
	    
	    
	    
	}
	
	
	public function bindPostG()
	{
	    
	    $phone=$_POST["phone"];
	    
        $Msg_code = M("Msg_code");
     	$codeData=$Msg_code->where("phone='".$phone."'")->find();
	    
	   
	    
	    if($codeData["code"]!=$_POST["code"])
	    {
	        $res["code"]="-1";
	        $res["msg"]="验证码不正确";
	       
	        
	    }
	     else if($codeData["phone"]!=$_POST["phone"])
	    {
	        $res["code"]="-2";
	        $res["msg"]="验证码发送的不是这个手机";
	    }
	    else{
            	$User = M("Member");
            	$data["phone"]=$_POST["phone"];
            	
            	$findData["phone"]=$_POST["phone"];
            	$findRs=$User->where($findData)->find();
            	
            	$data["nickname"]=$_POST["nickname"];
            	$data["avatar"]=$_POST["avatar"];
            	$data["gender"]=$_POST["sex"];
            	
            	if($findRs>0)
            	{
            	    
            	    $data["g_openid"]=$_POST["openid"];
            	    $data["unionid"]=$_POST["unionid"];
        	        $data["create_time"]=date("Y-m-d H:i:s");
        	        
        	    	$rs=$User->where("phone='".$_POST["phone"]."'")->save($data);
            	    $res["code"]="1";
                    $res["msg"]="绑定成功";
            	}
            	else{
            	    	$data["g_openid"]=$_POST["openid"];
            	    	$data["unionid"]=$_POST["unionid"];
            	        $data["create_time"]=date("Y-m-d H:i:s");
            	    	$rs=$User->add($data);
                    	if($rs)
                    	{
                	    	$res["code"]="1";
	                        $res["msg"]="绑定成功";
                    	}
                    	else{
                    	    $res["code"]="0";
	                        $res["msg"]="系统异常";
                    	}
            	}
            	
            
            
	    }
	    
	    echo json_encode($res);
	    
	    
	    
	    
	}
	
	public function sendCode()
	{
	    
	        vendor('REST');//导入类库

            
            
            
            /**
              * 发送模板短信
              * @param to 手机号码集合,用英文逗号分开
              * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
              * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
              */       
            function sendTemplateSMS($to,$datas,$tempId)
            {
                
                 //主帐号,对应开官网发者主账号下的 ACCOUNT SID
            $accountSid= '8a48b551506fd26f01507e5d4bf5212a';
            
            //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
            $accountToken= '11f48efde1e44133bd71d442e7e8d982';
            
            //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
            //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
            $appId='8a216da85b8e6bb1015ba914f02508b7';
            
            //请求地址
            //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
            //生产环境（用户应用上线使用）：app.cloopen.com
            $serverIP='app.cloopen.com';
            
            
            //请求端口，生产环境和沙盒环境一致
            $serverPort='8883';
            
            //REST版本号，在官网文档REST介绍中获得。
            $softVersion='2013-12-26';
                 
                 
                 $rest = new \REST($serverIP,$serverPort,$softVersion);
                 $rest->setAccount($accountSid,$accountToken);
                 $rest->setAppId($appId);
                
                 // 发送模板短信
                 //echo "Sending TemplateSMS to $to <br/>";
                 $result = $rest->sendTemplateSMS($to,$datas,$tempId);
                 if($result == NULL ) {
                     echo "result error!";
                     break;
                 }
                 if($result->statusCode!=0) {
                     echo "error code :" . $result->statusCode . "<br>";
                     echo "error msg :" . $result->statusMsg . "<br>";
                     //TODO 添加错误处理逻辑
                 }else{
                     //echo "Sendind TemplateSMS success!<br/>";
                     // 获取返回信息
                     $smsmessage = $result->TemplateSMS;
                     //echo "dateCreated:".$smsmessage->dateCreated."<br/>";
                     //echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
                     echo 1;
                     //TODO 添加成功处理逻辑
                 }
            }
            
            //Demo调用 
            		//**************************************举例说明***********************************************************************
            		//*假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为           *
            		//*result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");																		  *
            		//*则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入     *
            		//*********************************************************************************************************************
            		
    		function generate_code($length = 6) {
                return rand(pow(10,($length-1)), pow(10,$length)-1);
            }
            
            $msgCode=generate_code();
        	$phone=$_POST["phone"];
            $data["code"]=$msgCode;
            $data["phone"]=$phone;
            $data["create_time"]=time();
            
            $Msg_code = M("Msg_code");
	     	$rs=$Msg_code->where("phone='".$phone."'")->find();
	     	if($rs)
	     	{
	     	    $rs1=$Msg_code->where("msg_code_id=".$rs['msg_code_id'])->save($data);
	     	}
	     	else{
	     	    $rs1=$Msg_code->add($data);
	     	}
           
            		
            sendTemplateSMS($phone,array($msgCode,'5分钟'),"205212");//手机号码，替换内容数组，模板ID
	}


  
	

}


