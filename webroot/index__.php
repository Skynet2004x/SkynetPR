<?php
set_time_limit(0);
ini_set('memory_limit', -1);
define('NUM_INSERTS_IN_QUERY', 1000);
define('NUM_QUERIES', 1000);

// build query
$time = microtime(true);
$queries =  array();

$autors = array('Ivanoff','Petroff','Sidoroff','Mudakoff','Pupkin','Durkin','Tirlo','Murlo','Vasin','Petin');
$books_title = array('Book #1','Book #2','Book #3','Book #4','Book #5','Book #6','Book #7','Book #8','Book #9','Book #10');
$books_desc = array('Desc #1','Desc #2','Desc #3','Desc #4','Desc #5','Desc #6','Desc #7','Desc #8','Desc #9','Desc #10');
$years = array('1959','1856','1455','1695','2041','1785','1985','2011','2001','1545','4785');
$category = array('Politika','kino','musik','nauka','tehno','umor','TV','Radio','sport','games','PK');

mysql_connect('localhost', 'root', '') or die(mysql_error());
mysql_select_db('books') or die(mysql_error());
// autors
mysql_query('DELETE FROM `autors`') or die(mysql_error());
mysql_query('truncate `autors`') or die(mysql_error());

mysql_query('DELETE FROM `book`') or die(mysql_error());
mysql_query('truncate `book`') or die(mysql_error());

mysql_query('DELETE FROM `books_authors`') or die(mysql_error());
mysql_query('truncate `books_authors`') or die(mysql_error());

mysql_query('DELETE FROM `books_categories`') or die(mysql_error());
mysql_query('truncate `books_categories`') or die(mysql_error());

$i =0;
for($i = 0; $i < NUM_QUERIES; $i++){
	
	$queries =  array();
	$queries1 =  array();
	$queries2 =  array();
	$queries3 =  array();	
   $queries[$i] = "INSERT INTO `autors` (name, is_active) VALUES ";
   $queries1[$i] = "INSERT INTO `book` (title, description, year, is_active) VALUES ";
   $queries2[$i] = "INSERT INTO `books_authors` (id_book, id_authors) VALUES ";
   $queries3[$i] = "INSERT INTO `books_categories` (id_book, id_cat) VALUES ";
   for($j = 0; $j < NUM_INSERTS_IN_QUERY; $j++){
		
			$cur_autor = $autors[rand(0,9)];
			   
			$cur_books_title = $books_title[rand(0,9)];
			$cur_books_desc = $books_desc[rand(0,9)];
			$cur_years = $years[rand(0,9)];

			$cur_books_id = rand(0,9);
			$cur_users_id = rand(0,9);
			
			$cur_cat_id = rand(0,9);	
			
		   $queries[$i] .= "('{$cur_autor}',1),";
		   $queries1[$i] .= "('{$cur_books_title}','{$cur_books_desc}',{$cur_years}, 1),";
		   $queries2[$i] .= "({$cur_books_id},{$cur_users_id}),";
		   $queries3[$i] .= "({$cur_books_id},{$cur_cat_id}),";
   }
 echo "<br>";
   echo $i;
   $queries[$i] = rtrim($queries[$i], ',');
   $queries1[$i] = rtrim($queries1[$i], ', ');
   $queries2[$i] = rtrim($queries2[$i], ', ');
   $queries3[$i] = rtrim($queries3[$i], ', ');
   mysql_query($queries[$i]) or die(mysql_error());
   mysql_query($queries1[$i]) or die(mysql_error());
   mysql_query($queries2[$i]) or die(mysql_error());
   mysql_query($queries3[$i]) or die(mysql_error());   
}

echo "Building query took " . (microtime(true) - $time) . " seconds\n";

?>