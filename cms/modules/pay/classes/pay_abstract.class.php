<?php
abstract class paymentabstract
{
	protected $config = array();
	protected $product_info = array();
	protected $customter_info = array();
	protected $order_info = array();
	protected $shipping_info = array();

	public function set_config($config)
	{
		foreach ($config as $key => $value) $this->config[$key] = $value;
		return $this;
	}

	public function set_productinfo($product_info)
	{
		$this->product_info = $product_info;
		return $this;
	}

	public function set_customerinfo($customer_info)
	{
		$this->customer_info = $customer_info;
		return $this;
	}

	public function set_orderinfo($order_info)
	{
		$this->order_info = $order_info;
		return $this;
	}

	public function set_shippinginfo($shipping_info)
	{
		$this->shipping_info = $shipping_info;
		return $this;
	}

	public function get_code($button_attr = '')
	{
		if (strtoupper($this->config['gateway_method']) == 'POST') $str = '<form action="' . $this->config['gateway_url'] . '" method="POST" target="_blank">';
		else $str = '<form action="' . $this->config['gateway_url'] . '" method="GET" target="_blank">';
		$prepare_data = $this->getpreparedata();
		foreach ($prepare_data as $key => $value) $str .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
		$str .= '<input type="submit" ' . $button_attr . ' />';
		$str .= '</form>';
		return $str;
	}

	public function get_png($orderinfo){
		if(dr_count($orderinfo)>0){
			//生成图片  引入支付文件
			$input = pc_base::load_app_class('WxPayUnifiedOrder','pay');
			$input->SetBody($orderinfo['payment']);
			$input->SetAttach($orderinfo['contactname']);
			$input->SetOut_trade_no($orderinfo['trade_sn']);
			$input->SetTotal_fee($orderinfo['money']);
			$input->SetTime_start($orderinfo['addtime']);
			$input->SetTime_expire(date("YmdHis", $orderinfo['addtime'] + 600));
			$input->SetGoods_tag("商品标签暂时没用");
			$input->SetTrade_type("NATIVE");
			$input->SetProduct_id("123456789");//商品编号 充值系统 暂时没用
		 	$notify = pc_base::load_app_class('NativePay','pay');
		 	//实例化lib/class/方法
		 	$newconfig = pc_base::load_app_class('WxPayConfig','pay',true);
		 	
		 	$newconfig->index($this->config);

			$result = $notify->GetPayUrl($input,$newconfig);
			if($result['return_code']=="SUCCESS" && $result['return_msg']=="OK"){
				//实例化图片类 生成支付图片
				pc_base::load_sys_class('phpqrcode');
				//生成唯一的支付图片 当支付完成后删除支付图片信息
				//参数1  二维码生成主要参数
				//参数2  图片生成的位置
				QRcode::png($result["code_url"],$orderinfo['trade_sn'].'pay.png');
				
				$str ="<img src='".WEB_PATH.$orderinfo['trade_sn'].'pay.png'."' style='width:100px;height:100px;'>";
				// 写一个微信扫码支付结果通知的ajax
				$str .="<script type='text/javascript'>";
					$str .="function  succ(){
						$.ajax({
							url:'".WEB_PATH."index.php?m=pay&c=respond&a=respond_get',
							data:{'code':'Wxpay','trad_sn':'".$orderinfo['trade_sn']."'},
							type:'get',
							dataType:'json',
							success:function(mes){
								if(mes.code==0){
									clearInterval(interval3);
									if (confirm(mes.tips)) {
									    window.location.href='".WEB_PATH."index.php?m=pay&c=deposit';
								  	} else {
									    window.location.href='".WEB_PATH."index.php?m=pay&c=deposit';
								  	}
								}
							}
						})
					}
					var interval3=setInterval(function(){succ();},2000);";
				$str.="</script>";
				return $str;
			}else{
				return "生成支付图片失败,请联系管理员";	
			}
		}else{
			return "缺少订单信息";
		}
	}

	protected function get_verify($url,$time_out = "60") {
        $urlarr     = parse_url($url);
        $errno      = "";
        $errstr     = "";
        $transports = "";
        if($urlarr["scheme"] == "https") {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        } else {
            $transports = "tcp://";
            $urlarr["port"] = "80";
        }
        $fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
        if(!$fp) {
            die("ERROR: $errno - $errstr<br />\n");
        } else {
            fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
            fputs($fp, "Host: ".$urlarr["host"]."\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $urlarr["query"] . "\r\n\r\n");
            while(!feof($fp)) {
                $info[]=@fgets($fp, 1024);
            }
            fclose($fp);
            $info = implode(",",$info);
            return $info;
        }
    }


	abstract public function receive();

	abstract public function notify();

	abstract public function response($result);

	abstract public function getPrepareData();
}