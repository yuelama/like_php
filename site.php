<?php
/**
 * like_toutiao模块微站定义
 *
 * @author bendilaosiji
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Like_toutiaoModuleSite extends WeModuleSite {


    public function doWebsosuo(){
			global $_W,$_GPC;
			if($_GPC['type']=="sosuo"){
			   $key=$_GPC['keyword'];
$datas= pdo_fetchall("SELECT * FROM ".tablename('like_toutiao_users')." WHERE nickname LIKE :username", array(':username' => "%{$key}%"));
			   return json_encode($datas);
			}
	
	}
	public function doWebUsers() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		$sql="select * from ".tablename('like_toutiao_users');	
		$sources=pdo_fetchall($sql);
		//分页开始
		$total=count($sources);
		$pageindex=max($_GPC['page'],1);
		$pagesize=10;
		$pager=pagination($total,$pageindex,$pagesize);
		$p=($pageindex-1)*10;
		$sql.=" order by id desc limit ".$p." , ".$pagesize;
		$userslist=pdo_fetchall($sql);
		include $this->template('users');
	}
		public function doWebFenlei() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		$fenlei_data=pdo_getall('like_toutiao_categorys');
		include $this->template('fenlei');
	}
	//添加分类
	public function doWebcategoryadd(){
		global $_W,$_GPC;
		if($_POST){
			$cate=[
				'name'=>$_GPC['catename'],
				'createtime'=>time(),
			];
			$result=pdo_insert('like_toutiao_categorys',$cate);
			if($result){
				message('添加成功',$this->createWebUrl('Fenlei'),'success');
			}else{
				message('添加失败',$this->createWebUrl('Fenlei'),'error');
			}
		}
		include $this->template('categoryadd');
	}
	//删除分类
	   public function doWebcategorydel(){
			global $_W,$_GPC;
			$id=$_GPC['id'];
			$result=pdo_delete('like_toutiao_categorys',array('id'=>$id));
			if($result){
				message('删除成功',$this->createWebUrl('Fenlei'),'success');
			}else{
				message('删除失败',$this->createWebUrl('Fenlei'),'error');
			}
	   }
	   //修改分类
	   public function doWebcategoryupd(){
			global $_W,$_GPC;
			$id=$_GPC['id'];
			$cate=pdo_get('like_toutiao_categorys',array('id'=>$id));
			if($_POST){
				$catedata=[
					'id'=>$_GPC['cateid'],
					'name'=>$_GPC['catename'],
					'createtime'=>time(),
				];
			$result=pdo_insert('like_toutiao_categorys',$catedata,true);
			if($result){
				message('修改成功',$this->createWebUrl('Fenlei'),'success');
			}else{
				message('修改失败',$this->createWebUrl('Fenlei'),'error');
			}
			}
			include $this->template('categoryupd');
	   }

		public function doWebXinwen() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		$sql="select * from ".tablename('like_toutiao_news');	
		$sources=pdo_fetchall($sql);
		//分页开始
		$total=count($sources);
		$pageindex=max($_GPC['page'],1);
		$pagesize=10;
		$pager=pagination($total,$pageindex,$pagesize);
		$p=($pageindex-1)*10;
		$sql.=" order by id desc limit ".$p." , ".$pagesize;
		$newslist=pdo_fetchall($sql);
		
		
		
		include $this->template('xinwen');
	}
	 //添加新闻
	    public function doWebnewsadd(){
			global $_W,$_GPC;
			
			if($_POST){
				$news=[
				'title'=>$_GPC['title'],
				'category'=>$_GPC['category'],
				'newsimg'=>$_W['attachurl'].$_GPC['newsimg'],
				'content'=>$_GPC['content'],
				'author'=>$_GPC['author'],
				'readnums'=>$_GPC['readnums'],
				'createtime'=>time(),
				
				];
				$result=pdo_insert('like_toutiao_news',$news);
			if($result){
				message('添加成功',$this->createWebUrl('xinwen'),'success');
			}else{
				message('添加失败',$this->createWebUrl('xinwen'),'error');
			}
				
			}
			
			//获取分类
		   $fenleidata=pdo_getall('like_toutiao_categorys');
			include $this->template('newsadd');
		}
		//删除新闻
		public function doWebnewsdel(){
		
			global $_W,$_GPC;
			$id=$_GPC['id'];
			$result=pdo_delete('like_toutiao_news',array('id'=>$id));
			if($result){
				message('删除成功',$this->createWebUrl('xinwen'),'success');
			}else{
				message('删除失败',$this->createWebUrl('xinwen'),'error');
			}
		}
		
		//修改新闻
		public function doWebnewsupd(){
			global $_W,$_GPC;
			$id=$_GPC['id'];
			$newsdata=pdo_get('like_toutiao_news',array('id'=>$id));
			//获取分类
		   $fenleidata=pdo_getall('like_toutiao_categorys');
		   
		    if($_POST){
				$news=[
				'id'=>$_GPC['id'],
				'title'=>$_GPC['title'],
				'category'=>$_GPC['category'],
				'newsimg'=>$_W['attachurl'].$_GPC['newsimg'],
				'content'=>$_GPC['content'],
				'author'=>$_GPC['author'],
				'readnums'=>$_GPC['readnums'],
				'createtime'=>time(),
				
				];
				$result=pdo_insert('like_toutiao_news',$news,true);
			if($result){
				message('修改成功',$this->createWebUrl('xinwen'),'success');
			}else{
				message('修改失败',$this->createWebUrl('xinwen'),'error');
			}
			}
			include $this->template('newsupd');
			
		}
	 
		public function doWebShoucang() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		$sql="select * from ".tablename('like_toutiao_collection');	
		$sources=pdo_fetchall($sql);
		//分页开始
		$total=count($sources);
		$pageindex=max($_GPC['page'],1);
		$pagesize=10;
		$pager=pagination($total,$pageindex,$pagesize);
		$p=($pageindex-1)*10;
		$sql.=" order by id desc limit ".$p." , ".$pagesize;
		$collectionslist=pdo_fetchall($sql);
		
		
		
		include $this->template('collections');
	}
	

}