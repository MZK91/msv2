<?php


$tab = array(
	'albums',
	'artistes',
	'clips',
	'lyrics',
	'lifestyle',
	'news',
	'sons',
	'videos',
	'images',
	'carousel',
	'article'
	);

$hostname = '127.0.0.1';
$username = 'root';
$password = '';

$new = mysqli_connect($hostname, $username, $password , "mzk") or die("Error " . mysqli_error($new));

$i = 0;

$result = $new->query('select * from image ORDER BY id ASC');
while($donnees = mysqli_fetch_array($result)) {
    $image = mysqli_real_escape_string($new, stripslashes($donnees['image']));
    $image = preg_replace("/.+\/(.+)/",'$1',$image) ;
    //echo $req = "UPDATE `mzk`.`image` SET `image` = '".$image."' WHERE `image`.`id` = ".$donnees['id']."<br/>;";
    $req = "UPDATE `mzk`.`image` SET `image` = '".$image."' WHERE `image`.`id` = ".$donnees['id'].";";
    $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
    $i++;
}

?>