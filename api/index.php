<?php
error_reporting(E_ALL);

require 'flight/Flight.php';
require "query.class.php";
require "config.php";

Flight::register('db', 'mysqli', array(DB_HOST, DB_USER, DB_PASS, DB_NAME));

Flight::route('/api/categories(/@id)', function($id){
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
	header('Access-Control-Allow-Headers: Content-Type');
	
	$db = Flight::db();
	
	$page = Flight::request()->query->page;
	$pageSize = Flight::request()->query->pageSize;
	
    $query = new Query();
	$query->select();
    $query->table("gastos_categoria", "c");
	// $query->order("p.date DESC");
	

	if($page != "" && $pageSize != ""){
        $query->limit(($page * $pageSize) . "," . ($page * $pageSize + $pageSize));
    }
    
    if($id != ""){
        $query->where(["id = '$id'"]);
	}
	// echo $query->build(); die();
	
	$query_categories = $db->query($query->build());
	
	$data = array();
	while ($categorie = $query_categories->fetch_assoc()) {
		

		$data[] = $categorie;
	}

	if(count($data) == 0){
		Flight::json(array("Not found"));	
	}else{
		Flight::json($data);
	}
});

Flight::route('GET /api/gastos(/@id)', function($id){
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
	header('Access-Control-Allow-Headers: Content-Type');
	
	$db = Flight::db();
	
	$page = Flight::request()->query->page;
	$pageSize = Flight::request()->query->pageSize;
	
    $query = new Query();
	$query->select();
    $query->table("gastos_gasto", "g");
	$query->order("g.date DESC");
	

	if($page != "" && $pageSize != ""){
        $query->limit(($page * $pageSize) . "," . ($page * $pageSize + $pageSize));
    }
    
    if($id != ""){
        $query->where(["id = '$id'"]);
	}
	// echo $query->build(); die();
	
	$query_gastos = $db->query($query->build());
	
	$data = array();
	while ($gasto = $query_gastos->fetch_assoc()) {	

		$data[] = $gasto;
	}
	// echo getcwd();die();
	Flight::json($data);
});

Flight::route('POST /api/gastos', function(){
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
	header('Access-Control-Allow-Headers: Content-Type');
	
	$db = Flight::db();

	$request = Flight::request();

	$data = $request->data;
	 
	
	$page = Flight::request()->query->page;
	$pageSize = Flight::request()->query->pageSize;
	
    $query = new Query();
	$query->insert(array("'".$data->description."'", "'".$data->user_id."'", "'".$data->category_id."'", "'".$data->amount."'"));
	$query->table("gastos_gasto", "g");
	$query->columns(array("description", "user_id", "category_id", "amount"));
	
	// echo $query->build(); die();
	
	$query_gastos = $db->query($query->build());
	
			
	$data = array();
	if($query_gastos){
		$data = array("result" => "success");
	}else{
		$data = array("result" => "error");
	}

	Flight::json($data);
});
/*
Flight::route('/tags', function() {
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
	header('Access-Control-Allow-Headers: Content-Type');
	
	$db = Flight::db();
	
	$page = Flight::request()->query->page;
	$pageSize = Flight::request()->query->pageSize;
	
    $query = new Query();
	$query->select();
	$query->rawColumns("t.*, count(tp.post_id) AS hits");
	$query->table("blog_tags", "t");
	$query->leftJoin("blog_tag_post", "tp", "t.id = tp.id");
	$query->groupBy(array("tp.post_id"));

	$query_tags = $db->query($query->build());

	$data = array();
	while ($tag = $query_tags->fetch_assoc()) {
		$data[] = $tag;
	}

	if(count($data) == 0){
		Flight::json(array("Not found"));	
	}else{
		Flight::json($data);
	}
});

Flight::route('/post/@slug', function($slug) {
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
	header('Access-Control-Allow-Headers: Content-Type');
	
	$db = Flight::db();
	
	$page = Flight::request()->query->page;
	$pageSize = Flight::request()->query->pageSize;
	
    $query = new Query();
    $query->select();
    $query->table("blog_posts");
        
	$query->where(["slug LIKE '$slug'"]);

	$query_posts = $db->query($query->build());

	$data = array();
	while ($row = $query_posts->fetch_assoc()) {
		$data[] = $row;
	}

	if(count($data) == 0){
		Flight::json(array("Not found"));	
	}else{
		Flight::json($data);
	}
});

Flight::route("/feed", function(){
	$db = Flight::db();

	$query = new Query();
	$query->select();
	$query->table("blog_posts");
	$query->order("date DESC");
	$query_posts = $db->query($query->build());
	
	$posts = array();
	while ($row = $query_posts->fetch_assoc()) {
		$posts[] = $row;
	}

	$response = '
		<?xml version="1.0" encoding="utf8"?>
		<rss version="2.0">
			<channel>
				<title>Example RSS feed</title>
				<description>Example of a RSS feed, part of a programming tutorial on making a feed in PHP.</description>
				<link>http://blog.com/</link>
				<copyright>Copyright (C) 2008 Broculos.net</copyright>';
	foreach($posts as $post){
		$response .= "
				<item>
					<title>".$post['title']."</title>
					<description>".$post['content']."</description>
					<link>http://blog.com/posts/".$post['slug']."</link>
					<pubDate>".$post['date']."</pubDate>
				</item>
		";
	}
	$response .= '</channel>
		</rss>
	';
	header('Content-Type: application/rss+xml');
	echo $response;
	die();
});
*/
Flight::start();

