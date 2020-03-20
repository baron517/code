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
class WeixinController extends BaseController {

		
	function http_request($url, $data = null, $headers = array())
    {
        $curl = curl_init();
        if (count($headers) >= 1) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
		
	
	  private function order_number($openid){
        //date('Ymd',time()).time().rand(10,99);//18位
        return md5($openid.time().rand(10,99));//32位
    }
    
    
    //获取xml
    private function xml($xml){
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $vals, $index);
        xml_parser_free($p);
        $data = "";
        foreach ($index as $key=>$value) {
            if($key == 'xml' || $key == 'XML') continue;
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;
        }
        return $data;
    }
    
    
       //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    
    //作用：生成签名
    private function getSign($data)
    {
        $stringA = '';
        foreach ($data as $key => $value) {
            if (!$value) continue;
            if ($stringA) $stringA .= '&' . $key . "=" . $value;
            else $stringA = $key . "=" . $value;
        }
        $wx_key = c("Api");//申请支付后有给予一个商户账号和密码，登陆后自己设置key
        $stringSignTemp = $stringA . '&key=' . $wx_key;//申请支付后有给予一个商户账号和密码，登陆后自己设置key 
        
        return strtoupper(md5($stringSignTemp));
    }
		

    //小程序获取openid
	public function getOpenid() {
	    
	    
	    $appid = c("Appid");
        $appSecret=c("AppSecret");
        $code=$_GET["code"];
	    
	    //sp_log($code);
	    
	    $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appSecret."&js_code=".$code."&grant_type=authorization_code";
	    
    	$data = array();
		$header = array();

		$response = $this->curl_https($url, $data, $header, 5);
		
		//sp_log($response);
		
		$rsObj=json_decode($response);
		
		
		$openid=$rsObj->openid;
	
		
		 $Member = M("Auto_member");
     	 $rs=$Member->where("openid='".$openid."'")->find();
     	 
     	 
		 if($rs)
		 {
			 
			$saveData["token"]=$this->getToken();
		    $saveData["expire_time"]=date('Y-m-d H:i:s',strtotime('+30 day'));
		    $Member->where("m_openid='".$openid."'")->save($saveData);
		    
		    $rs=$Member->where("m_openid='".$openid."'")->find();
			 
		    $rsObj->exist=1; 
		    $rsObj->user_info=$rs;
		    
		    
		 }
		 else{
		     $rsObj->exist=0; 
		     
		 }
		 
		echo json_encode($rsObj);
	    
	   
	}

	
	public function getOrder()
	{
	    $M= M("Auto_order");
	    $data["o_openid"]=$_GET["openid"];
	    $rs=$M->where($data)->select();
	    $res["code"]="1000";
        $res["msg"]="成功";
        $res["data"]=$rs;
        
        echo json_encode($res);
        
	}
	
	
	
	public function addOrder()
	{
	    $M= M("Auto_order");
	    $data=$M->create();
	    
	    if($_POST["o_openid"])
	    {
	        $data["o_create_time"]=date("Y-m-d H:i:s");
	        $rs=$M->add($data);
	        
	        if($rs)
	        {
	            $res["code"]="1000";
                $res["msg"]="成功";
                $res["data"]["o_id"]=$rs;
	        }
	        else{
	            $res["code"]="1001";
                $res["msg"]="下单失败";
	        }
	        
	    }
	    else{
	        
	        $res["code"]="1001";
            $res["msg"]="用户信息不能为空";
	        
	    }
	    
	    echo json_encode($res);
	    
	    
	}
	
	
	//签名接口
    public function weixinPay()
    {
        
       
        
        $fee=$_POST['fee'];
        $details=$_POST['detail'];//商品的详情，比如iPhone8，紫色
        $appid =        c("Appid");//appid
        $body =        $_POST["body"];
        $mch_id =       c("Mch_id");//'你的商户号【自己填写】'
        $nonce_str =    $this->createNoncestr();//随机字符串
        $notify_url =   c("SERVER_URL").'/Api/Weixin/notify';//回调的url【自己填写】';
        $openid =       $_POST['openid'];//'用户的openid【自己填写】';
        $out_trade_no = $this->order_number($openid);//商户订单号
        $spbill_create_ip = '47.99.106.117';//'服务器的ip【自己填写】';
        $total_fee =    $fee*100;//因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
        $trade_type = 'JSAPI';//交易类型 默认
        //这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
        
        $post['appid'] = $appid;
        $post['attach'] = $body;
        $post['body'] = $body;
        $post['mch_id'] = $mch_id;
      
        $post['nonce_str'] = $nonce_str;//随机字符串
      
        $post['notify_url'] = $notify_url;
      
        $post['openid'] = $openid;
      
        $post['out_trade_no'] = $out_trade_no;
      
        $post['spbill_create_ip'] = $spbill_create_ip;//终端的ip
      
        $post['total_fee'] = $total_fee;//总金额 最低为一块钱 必须是整数
     
        $post['trade_type'] = $trade_type;
        
         sp_log(json_encode($post),"weixinPay.txt");
        
        
        
        $sign = $this->getSign($post);//签名
       
        
        $post_xml = '<xml>
           <attach>'.$body.'</attach>
           <appid>'.$appid.'</appid>
           <mch_id>'.$mch_id.'</mch_id>
           <nonce_str>'.$nonce_str.'</nonce_str>
           <sign>'.$sign.'</sign>
           <body>'.$body.'</body>
           <out_trade_no>'.$out_trade_no.'</out_trade_no>
          <total_fee>'.$total_fee.'</total_fee>
          <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
           <notify_url>'.$notify_url.'</notify_url>
           <openid>'.$openid.'</openid>
           <trade_type>'.$trade_type.'</trade_type>
        </xml> ';
        
        
        
        sp_log($post_xml,"weixinPay.txt");
        
        //统一接口prepay_id
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = $this->http_request($url,$post_xml);
        $array = $this->xml($xml);//全要大写
        
        
        if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
            $time = time();
            $tmp='';//临时数组用于签名
            $tmp['appId'] = $appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = "$time";

            $data['code'] = 1000;
            $data['timeStamp'] = "$time";//时间戳
            $data['nonceStr'] = $nonce_str;//随机字符串
            $data['signType'] = 'MD5';//签名算法，暂支持 MD5
            $data['package'] = 'prepay_id='.$array['PREPAY_ID'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->getSign($tmp);//签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;

        }else{
            $data['code'] = 1001;
            $data['RETURN_CODE'] = $array['RETURN_CODE'];
            $data['msg'] = $array['RETURN_MSG'];
        }
        
        
         echo json_encode($data);
        
        
        
    }


   public function notify()
    {
        
            sp_log("支付回调开始","zhifu.txt");
        
		   $input = file_get_contents('php://input');
		   
		   sp_log("*************************************out_trade_no**********************".$_GET['out_trade_no'],"zhifu.txt");
		   
		   
        if (!empty($input) && empty($_GET['out_trade_no'])) {
            $obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
            $returnData = json_decode(json_encode($obj), true);
            
            sp_log(json_encode($obj),"zhifu.txt");
            
            if($returnData["result_code"]=="SUCCESS")
            {
                $o_id=$returnData["attach"];
                
                
                if($o_id)
                {
                   
                  $M= M("Auto_order");
                  $findData["o_id"]=$o_id;
                  $saveData["o_status"]=1;
                  $M->where($findData)->save($saveData);
                    
                    
                }
                
                
                
            }
            
            
        }
        
        
        
        
    }
  
  
   //获取微信公众号openid
   public function getWxOpenId() {
	    
	    
	    $appid = c("WxAppid");
        $appSecret=c("WxAppSecret");
        $code=$_GET["code"];
	    
	    //sp_log($code);
	    
	   $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
    	$data = array();
		$header = array();

		$response = $this->curl_https($url, $data, $header, 5);
		
		
		$rsObj=json_decode($response);
		
		
		$openid=$rsObj->openid;
		 
        if($openid)
		{
		     $Member = M("Auto_member");
         	 $rs=$Member->where("m_openid='".$openid."'")->find();
         	 
         	 
    		 if($rs)
    		 {
    		    header("Location:https://mall.xiuqiupaopaopao.com/h5/index.html?openid=".$openid);  
    		    
    		    
    		 }
    		 else{
    		     
    		     header("Location:https://mall.xiuqiupaopaopao.com/h5/index.html?openid=".$openid);
    		     
    		     //header("Location: http://mall.xiuqiupaopaopao.com/h5/#/pages/bind_phone/bind_phone?openid=".$openid);  
    		     
    		 }
		    
		}
		else{
		    echo "openid获取失败";
		}
	    
	   
	}

	

}


