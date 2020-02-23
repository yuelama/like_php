<?php
/**
 * like_toutiao支付宝小程序接口定义
 *
 * @author bendilaosiji
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Like_toutiaoModuleAliapp extends WeModuleAliapp {
	public function doPageTest(){
		global $_GPC, $_W;
		// 此处开发者自行处理
		include $this->template('test');
	}
}