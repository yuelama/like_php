<?php
/**
 * like_toutiao模块小程序接口定义
 *
 * @author bendilaosiji
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Like_toutiaoModuleWxapp extends WeModuleWxapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
	//获取分类方法
	public function doPagegetcategorys(){
		global $_GPC, $_W;
		$fenleidata=pdo_getall('like_toutiao_categorys');
		$this->result(0, "服务器获取分类数据成功", array('fenleidata'=>$fenleidata));
	}
  
   //获取活动信息方法
	public function doPagesgetevents(){
			global $_GPC, $_W; 
           var_dump($_GPC);
           die;
      
			$events = pdo_get('like_toutiao_events',array('userid'=>$_W['openid']));
			if($events){
				$this->result(0, "服务器获取活动信息成功", array('status'=>0));
			}else{
				$eventdata=[
					'userid'=>$_W['openid'],
                 //  'headimg'=>$_GPC['headimg'],
                  'username'=>$_GPC['realname'],
                    'contactValue'=>$_GPC['contactValue'], 
                   'title'=>$_GPC['title'],				
                    'content' =>$_GPC['content'],
			        'endtime'=>$_GPC['endtime'],               
                    'peoplenum'=>$_GPC['peoplenum'], 
                      'actpic'=>$_GPC['src'],       //添加图片
                    // 'acttypename'=>$_GPC['acttypename'],  //活动类型
                     'typeIndex'=>$_GPC['typeIndex'], //活动类型编号    
                     //'acttype'=>$_GPC['acttype'],    //活动类型  
                     'free'=>$_GPC['free'],	
			        'address'=>$_GPC['address'],               
                    'longitude'=>$_GPC['longitude'],                
                     'latitude'=>$_GPC['latitude'],                                   
                    'readnums'=>$_GPC['readnums'],      //阅读人数	          
                   //  'liker'=>$_GPC['liker'],	    //收藏者			
                   //  'joinnumber'=>$_GPC['joinnumber'],     //报名者                                             
				];      
				$result = pdo_insert('like_toutiao_events',$eventdata);
				if($result){
					$this->result(0, "服务器获取活动信息成功", array('status'=>0));
				}else{
					$this->result(0, "服务器获取活动信息失败", array('status'=>1));
				}
			}
	}
  
  public function doPagegetimgurl(){
		global $_GPC, $_W;
     
        // var_dump($_GPC);
      
     load()->func('file');
      $img_file = file_upload($_FILES['imgfile'], 'image', '');
     // $img_src = $_W['attachurl'].$img_file['path'];
     
      $img_src = $_W['siteroot'] .'attachment/' .$img_file['path'];
     
      $this->result(0, "获取图片地址", array('img'=>$img_src));
  
  }

    	//测试
	public function doPagegettest(){
		global $_GPC, $_W; 
       $events = pdo_get('like_toutiao_events',array('title'=>$_W['title']));
			if($events){
				$this->result(0, "服务器获取活动信息成功", array('status'=>0));
			}else{
				$eventdata=[
					'userid'=>$_W['openid'],
                 //  'headimg'=>$_GPC['headimg'],
                  'username'=>$_GPC['realname'],
                    'contactValue'=>$_GPC['contactValue'], 
                   'title'=>$_GPC['title'],				
                    'content' =>$_GPC['content'],
			        'endtime'=>$_GPC['endtime'],               
                    'peoplenum'=>$_GPC['peoplenum'], 
                     'actpic'=>$_GPC['src'],    //获取封面图片
                  
                  
                    // 'acttypename'=>$_GPC['acttypename'],  //活动类型
                     'acttype'=>$_GPC['acttype'], //活动类型编号    
                     //'acttype'=>$_GPC['acttype'],    //活动类型  
                     'free'=>$_GPC['free'],	
			        'address'=>$_GPC['address'],               
                    'longitude'=>$_GPC['longitude'],                
                     'latitude'=>$_GPC['latitude'],                                   
                    'readnums'=>$_GPC['readnums'],      //阅读人数	          
                   //  'liker'=>$_GPC['liker'],	    //收藏者			
                   //  'joinnumber'=>$_GPC['joinnumber'],     //报名者                                             
				];                    
				$result = pdo_insert('like_toutiao_events',$eventdata);
				if($result){
					$this->result(0, "服务器获取活动信息成功", array('status'=>0));
				}else{
					$this->result(0, "服务器获取活动信息失败", array('status'=>1));
				}
			}  
      
      // var_dump($_GPC);
      
	//load()->func('logging');
       //记录文本日志
     // logging_run($_GPC);

     // $this->result(0, "服务器获取数据成功", array(1,2,3,4));
      
	}
  
  
  
  
  
	//获取指定分类新闻数据
	/* public function doPagegetnews(){
		global $_GPC, $_W;
		$newsdata=pdo_getall('like_toutiao_news',array('category'=>$_GPC['category']));
		$this->result(0, "服务器获取新闻数据成功", array('newsdata'=>$newsdata));
	} */
	
	
	public function doPagegetnews(){
		global $_GPC, $_W;
	$sql = 'select i.*,c.name  from ' . tablename('like_toutiao_categorys') .
                  ' as c left join ' . tablename('like_toutiao_events') . ' as i on i.acttype = c.id where i.acttype=' .$_GPC['category'] . '
                  order by c.id asc';		  			  		  
              $newsdata = pdo_fetchall($sql);		
		
		//$newsdata=pdo_getall('like_toutiao_news',array('category'=>$_GPC['category']));
		$this->result(0, "服务器获取新闻数据成功", array('newsdata'=>$newsdata));
	}
	
	
	
	//获取单篇文章的方法
	/* public function doPagegetarticle(){
		global $_GPC, $_W;
		$newsdata=pdo_get('like_toutiao_news',array('id'=>$_GPC['id']));
		$this->result(0, "服务器获取新闻数据成功", array('newsdata'=>$newsdata));
	}
   */

    	public function doPagegetarticle(){
		global $_GPC, $_W;
		$sql = 'select i.*,c.name  from ' . tablename('like_toutiao_categorys') .
                  ' as c left join ' . tablename('like_toutiao_events') . ' as i on i.acttype = c.id where  i.id=' .$_GPC['id'] . '
                  order by i.id asc';		  
		
		 $newsdata = pdo_fetchall($sql);	
		$this->result(0, "服务器获取新闻数据成功", array('newsdata'=>$newsdata));
	}
	

  
  
  
  
  
  
  
	//获取用户userid
	public function doPagegetuserid(){
	    global $_GPC, $_W;
		$userdata= pdo_get('like_toutiao_users',array('openid'=>$_W['openid']));
		if($userdata){
			$this->result(0, "服务器获取用户成功", array('status'=>0,'userid'=>$userdata['openid']));
		}else{
			$this->result(0, "服务器获取用户失败", array('status'=>1));
		}
	}
	//注册用户的方法
	public function doPagereguser(){
		global $_GPC, $_W;
		
		$hasuser=pdo_get('like_toutiao_users',array('openid'=>$_W['openid']));
		if($hasuser){
			$this->result(0, "服务器获取用户成功", array('status'=>0,'userid'=>$_W['openid']));
		}else{
			$user=[
			'openid'=>$_W['openid'],
			'headimg'=>$_GPC['headimg'],
			'nickname'=>$_GPC['nickname'],
			'regtime'=>time(),
		];
		$result = pdo_insert('like_toutiao_users',$user);
		if($result){
			$this->result(0, "服务器注册用户成功", array('status'=>0,'userid'=>$_W['openid']));
		}else{
			$this->result(0, "服务器注册用户失败", array('status'=>1));
		}
		
		}
		
		
	}
	//收藏文章的方法
	public function doPageshoucang(){
			global $_GPC, $_W;
			$hasshoucang = pdo_get('like_toutiao_collection',array('openid'=>$_GPC['userid']));
			if($hasshoucang){
				$this->result(0, "服务器收藏文章成功", array('status'=>0));
			}else{
				$scdata=[
					'newid'=>$_GPC['id'],
					'openid'=>$_GPC['userid'],
					'createtime'=>time(),
				];
				$result = pdo_insert('like_toutiao_collection',$scdata);
				if($result){
					$this->result(0, "服务器收藏文章成功", array('status'=>0));
				}else{
					$this->result(0, "服服务器收藏文章失败", array('status'=>1));
				}
			}
	}

	
	
}