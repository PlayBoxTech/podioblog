<?php

class SitemapController 
{
	public function sitemap()
	{
		$f3=Base::instance();
		$db=new DB\SQL(
			$f3->get('db_dns') . $f3->get('db_name'),
			$f3->get('db_user'),
			$f3->get('db_pass')
		);
		$page = new Page($db,$f3->get("table_prefix"));
		$sitemapurls=$page->sitemappages();
		
		$f3->set('urls',$sitemapurls);
		
		header('Content-Type: text/xml; charset=UTF-8');
		$view=\View::instance();
		echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
		echo Template::instance()->render('/sitemap/sitemap.xml', 'application/xml');
		die;
	}	

	public function rss()
	{
		$f3=Base::instance();
		$db=new DB\SQL(
			$f3->get('db_dns') . $f3->get('db_name'),
			$f3->get('db_user'),
			$f3->get('db_pass')
		);
		//$page = new Page($db,$f3->get("table_prefix"));
		//$sitemapurls=$page->rss();
		
		$sql="select longtitle, description,created_at, alias FROM ".$table_prefix."site_content WHERE published=1 AND type='document'";
		$sitemapurls=$db->exec($sql);
		$f3->set('urls',$sitemapurls);
		
		header('Content-Type: text/xml; charset=UTF-8');
		$view=\View::instance();
		echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
		echo Template::instance()->render('/sitemap/site.rss', 'application/xml');
		die;
	}

}