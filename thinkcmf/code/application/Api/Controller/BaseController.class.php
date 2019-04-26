<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Api\Controller;

require "lib/sendMsg/aliyun/SignatureHelper.php";
require "lib/ai/AipOcr.php";


use Think\Controller;
use AipOcr;
use Aliyun\DySDKLite\SignatureHelper;

header("Access-Control-Allow-Origin: *");

/**
 * 首页
 */
class BaseController extends Controller {
    
    
    //阿里短信接口
	public function sendMobileMsg($phone,$TemplateCode,$bianliang)
	{
	    
	    
	      // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
                $accessKeyId = "LTAIwVKKGrDY5nwq";
                $accessKeySecret = "pfmLwxQyLHuuI01Vfq0VkuyLOXrCq1";
            
                // fixme 必填: 短信接收号码
                $params["PhoneNumbers"] = $phone;
            
                // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
                $params["SignName"] = "一情科技";
            
                // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
                $params["TemplateCode"] = $TemplateCode;
            
                // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
                $params['TemplateParam'] = $bianliang;
            
                // fixme 可选: 设置发送短信流水号
                $params['OutId'] = "12345";
            
                // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
                $params['SmsUpExtendCode'] = "1234567";
                
                sp_log(json_encode($params)."\n","mobileMsg.txt");
            
            
                // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
                if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
                    $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
                }
            
                // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
                $helper = new SignatureHelper();
                
            
                // 此处可能会抛出异常，注意catch
                $content = $helper->request(
                    $accessKeyId,
                    $accessKeySecret,
                    "dysmsapi.aliyuncs.com",
                    array_merge($params, array(
                        "RegionId" => "cn-hangzhou",
                        "Action" => "SendSms",
                        "Version" => "2017-05-25",
                    ))
                    // fixme 选填: 启用https
                    // ,true
                );
                
                
                sp_log(json_encode($content)."\n","mobileMsg.txt");
                
                $sendCodeRs=$content->Code;
                
                return $sendCodeRs;
	    
	}
	
	public function sendAdminMsg()
	{
	    
	    $phone=$_GET["phone"];
	     $TemplateCode=$_GET["template_code"];
	      $bianliang=[];
	    $this->sendMobileMsg($phone,$TemplateCode,$bianliang);
	}
	
	
	//创建定时任务
	public function createDingshi($ds_phone,$ds_type,$ds_time)
	{
	    $M=M("Auto_dingshi");
	    $data["ds_phone"]=$ds_phone;
	    $data["ds_type"]=$ds_type;
	    $data["ds_time"]=$ds_time;
	    
	    $M->add($data);
	    
	}
    
      //模板推送
    public function mubanMsg($openid,$formid,$ko_id)
    {
        
         sp_log($formid."\n","mubanMsg.txt");
         sp_log($ko_id."\n","mubanMsg.txt");
         sp_log($openid."\n","mubanMsg.txt");
        
        
	    $M= M("Auto_kecheng_order");
	    $findData["ko_id"]=$ko_id;
	    
	    $rs=$M->join("left join tb_auto_kecheng on tb_auto_kecheng_order.ko_kc_id=tb_auto_kecheng.k_id")->join("left join tb_auto_laoshi on tb_auto_kecheng_order.ko_ls_id=tb_auto_laoshi.ls_id")->join("left join tb_auto_member on tb_auto_kecheng_order.ko_openid=tb_auto_member.openid")->where($findData)->find();
        
        
            $data_arr = array(
              'keyword1' => array( "value" => $ko_id),
              'keyword3' => array( "value" => $rs["ko_time"], "color" => "red" ) ,
              'keyword4' => array( "value" => "联系人：".$rs["truename"]." 联系电话：".$rs["phone"]."地址：".$rs["ko_sheng"].$rs["ko_shi"].$rs["ko_qu"].$rs["ko_address"] ) ,
              'keyword5' => array( "value" => $rs["ko_liuyan"]) 
              //这里根据你的模板对应的关键字建立数组，color 属性是可选项目，用来改变对应字段的颜色
            );
            $post_data = array (
              "touser"           => $openid,
              //用户的 openID，可用过 wx.getUserInfo 获取
              "template_id"      => "B1jc-9gzzJkurDckqPsUmd54dPPiXxoiLtf9wbwdPg0",
              //小程序后台申请到的模板编号
              "page"             => "/pages/index/main?id=".$ko_id,
              //点击模板消息后跳转到的页面，可以传递参数
              "form_id"          => $formid,
              //第一步里获取到的 formID
              "data"             => $data_arr
              //"emphasis_keyword" => "keyword3.DATA"
              //需要强调的关键字，会加大居中显示
            );
             
            function send_post( $url, $post_data ) {
              $options = array(
                'http' => array(
                  'method'  => 'POST',
                  'header'  => 'Content-type:application/json',
                  //header 需要设置为 JSON
                  'content' => $post_data,
                  'timeout' => 60
                  //超时时间
                )
              );
             
              $context = stream_context_create( $options );
              $result = file_get_contents( $url, false, $context );
             
              return $result;
            }
             
             $access_token=$this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token;  
            //这里替换为你的 appID 和 appSecret
            $data = json_encode($post_data, true);   
            //将数组编码为 JSON
             
            $return = send_post( $url, $data);
            sp_log($return,"mubanMsg.txt");
        
    }
    
    public function getAccessToken()
    {
        
      $M=M("Auto_access_token");
      $findData["ac_id"]=1;
      $rs=$M->where($findData)->find();
     
      return $rs["ac_access_token"];
        
    }
    
    
    //定时任务access_token
    public function updateAccessToken()
    {
        
      $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.c("WxAppid").'&secret='.c("WxAppSecret");
      $html = file_get_contents($url);
      
      $output = json_decode($html, true);
      $access_token= $output['access_token'];
      
      
      if($access_token)
      {
          $M=M("Auto_access_token");
          $data["ac_access_token"]=$access_token;
          $data["ac_update_time"]=date("Y-m-d H:i:s");
          $findData["ac_id"]=1;
          $rs=$M->where($findData)->save($data);
          
          //echo $M->getlastSql();
          
          echo $rs;
          
      }
     
      
        
    }
    
    

    //百度ocr
	public function ocrIdCard($url)
	{
	    
	    $appId = '15117244';
	    $apiKey = '4Pzow6M1HcWhBe88yVGxRQX9';
	    $secretKey = '8GFRzeLsWd2Y7KOdAeg6clFFxddRUee6';
	    
	    // 初始化
        $aipOcr = new AipOcr($appId,$apiKey,$secretKey);
        
        $file=file_get_contents($url);
        
        // 身份证识别
        return ($aipOcr->idcard($file, "front"));
	}

  
    public function curl_https($url, $data=array(), $header=array(), $timeout=30){

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
	

   

}


