<?php

function title_to_url($url){
	$url = stripslashes(trim($url));
	$url = strtr($url,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ$","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNns");
	$url = strtolower($url);
	$url = preg_replace('/[^a-z0-9-]/','-', $url);
	$url = preg_replace('/[-]{2,}/','-', $url); //On enlève les underscore si ils sont au moins répétés deux fois
	$url = preg_replace('/^[-]/','', $url); //On enlève les underscore en début de chaine
	$url = preg_replace('/[-]$/','', $url); //On enlève les underscore en fin de chaine
	return $url;
}

$tab = array(
	'albums',
	'artistes',
	'clips',
	'lyrics',
	'lifestyle',
	'news',
	'sons',
	'videos',
	//'images',
	//'carousel',
	//'article'
	);

$hostname = '127.0.0.1';
$username = 'root';
$password = '';

$old = mysqli_connect($hostname, $username, $password , "muzikspirit") or die("Error " . mysqli_error($old));
$new = mysqli_connect($hostname, $username, $password , "mzk") or die("Error " . mysqli_error($new));


$new->query("DELETE FROM album") or die("Error " . mysqli_error());
$new->query("DELETE FROM artiste") or die("Error " . mysqli_error());
$new->query("DELETE FROM clip") or die("Error " . mysqli_error());
$new->query("DELETE FROM lyrics") or die("Error " . mysqli_error());
$new->query("DELETE FROM news") or die("Error " . mysqli_error());
$new->query("DELETE FROM son") or die("Error " . mysqli_error());
$new->query("DELETE FROM video") or die("Error " . mysqli_error());
$new->query("DELETE FROM lifestyle") or die("Error " . mysqli_error());

$new->query("DELETE FROM section") or die("Error " . mysqli_error());
/*
$result = $old->query('select * from type_section ORDER BY id_section ASC');
while($donnees = mysqli_fetch_array($result)) {
        $req = "
			INSERT INTO section
			SET
			id = " . $donnees['id_section'] . ",
			titre = '" . mysqli_real_escape_string($new, stripslashes($donnees['titre_section'])) . "',
			url = '" . mysqli_real_escape_string($new, stripslashes($donnees['url_section'])) . "'
			";
        //echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
}

$new->query("DELETE FROM type_article") or die("Error " . mysqli_error());
$result = $old->query('select * from type_article ORDER BY id_type ASC');
while($donnees = mysqli_fetch_array($result)) {
        $req = "
			INSERT INTO type_article
			SET
			id = " . $donnees['id_type'] . ",
			titre = '" . mysqli_real_escape_string($new, stripslashes($donnees['titre_type'])) . "'
			";
        //echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
}

$new->query("DELETE FROM type_article_lifestyle") or die("Error " . mysqli_error());
$result = $old->query('select * from type_cat_swagg ORDER BY id_type ASC');
while($donnees = mysqli_fetch_array($result)) {
    $req = "
			INSERT INTO type_article_lifestyle
			SET
			id = " . $donnees['id_type'] . ",
			titre = '" . mysqli_real_escape_string($new, stripslashes($donnees['titre_type'])) . "',
			url = '" . mysqli_real_escape_string($new, stripslashes($donnees['url_type'])) . "'
			";
    //echo $req.'</br>';
    $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
}
//IPBOARD $hash = md5( md5( $salt ) . md5( $password ) );

$new->query("DELETE FROM user") or die("Error " . mysqli_error());
$result = $old->query('select * from z_members ORDER BY member_id ASC');
while($donnees = mysqli_fetch_array($result)) {
    if($donnees['name'] != '') {
        $req = "
			INSERT INTO user
			SET
			id = " . $donnees['member_id'] . ",
			username = '" . mysqli_real_escape_string($new, stripslashes($donnees['name'])) . "',
			email = '" . mysqli_real_escape_string($new, stripslashes($donnees['email'])) . "',
			username_canonical = '" . mysqli_real_escape_string($new, stripslashes($donnees['name'])) . "',
			email_canonical = '" . mysqli_real_escape_string($new, stripslashes($donnees['email'])) . "',
			enabled = '1'
			";
        //echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
    }
}

*/


if(in_array('albums', $tab)){
	$new->query('TRUNCATE album') or die("Error " . mysqli_error());
	$result = $old->query('select * from albums ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }

		$req = '
			INSERT INTO album
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			album = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			tracklist = \''.mysqli_real_escape_string($new,stripslashes($donnees['tracklist_album'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
	$result = $old->query('select * from sorties_albums ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
		if($donnees['id_album'] != 0){
			$req = '
			UPDATE album
			SET
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['nom_artiste'])).'\',
			album = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_album'])).'\',
			date_sortie = \''.date("Y-m-d H:i:s",$donnees['date_sortie']).'\',
			mixtape = \''.$donnees['mixtape'].'\'
			WHERE id = \''.$donnees['id_album'].'\'
			';
			//echo $req.'</br>';
            $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
		}
	}
}

if(in_array('artistes', $tab)){
	$new->query('DELETE FROM artiste') or die("Error " . mysqli_error());
	$result = $old->query('select * from artistes ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
		$req = '
			INSERT INTO artiste
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}

if(in_array('clips', $tab)){
	$new->query('DELETE FROM clip') or die("Error " . mysqli_error());
	$result = $old->query('select * from clips ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
		$req = '
			INSERT INTO clip
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			featuring = \''.mysqli_real_escape_string($new,stripslashes($donnees['featuring'])).'\',
			son = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}

if(in_array('lifestyle', $tab)){
	$new->query('DELETE FROM lifestyle') or die("Error " . mysqli_error());
	$result = $old->query('select * from swagg ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
        if($donnees['id_type_cat'] == 0){
            $type_article_lifestyle = 1;
        }else{
            $type_article_lifestyle = $donnees['id_type_cat'];
        }
		$req = '
			INSERT INTO lifestyle
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			category_lifestyle_id = \''.$type_article_lifestyle.'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}

if(in_array('lyrics', $tab)){
	$new->query('DELETE FROM lyrics') or die("Error " . mysqli_error());
	$result = $old->query('select * from lyrics ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
		$req = '
			INSERT INTO lyrics
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			album_id = \''.$donnees['id_album'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			featuring = \''.mysqli_real_escape_string($new,stripslashes($donnees['featuring'])).'\',
			son = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			media = \''.$donnees['media'].'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}
if(in_array('news', $tab)){
	$new->query('DELETE FROM news') or die("Error " . mysqli_error());
	$result = $old->query('select * from news ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
		$req = '
			INSERT INTO news
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			thumb_news = \''.mysqli_real_escape_string($new,stripslashes($donnees['thumbnail_news'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}

if(in_array('sons', $tab)){
	$new->query('DELETE FROM son') or die("Error " . mysqli_error());
	$result = $old->query('select * from sons ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
		$req = '
			INSERT INTO son
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			featuring = \''.mysqli_real_escape_string($new,stripslashes($donnees['featuring'])).'\',
			son = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}

if(in_array('videos', $tab)){
	$new->query('DELETE FROM video') or die("Error " . mysqli_error());
	$result = $old->query('select * from videos ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
        if($donnees['id_user'] == 0){
            $id_user = 'NULL';
        }else{
            $id_user = $donnees['id_user'];
        }
        if($id_user != 'NULL') {
            $result2 = $new->query('select id from user WHERE id=' . $donnees['id_user']);
            echo $result2->num_rows;
            if ($result2->num_rows == 0) {
                $id_user = 'NULL';
            } else {
                $id_user = $donnees['id_user'];
            }
        }
		$req = '
			INSERT INTO video
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = '.$id_user.',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			last_visit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}
if(in_array('images', $tab)){
	$new->query('DELETE FROM image') or die("Error " . mysqli_error());
	$result = $old->query('select * from imghost WHERE news = 0 ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO image
			SET
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			image = \''.$donnees['img'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			type_image_id = 1
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
	$result = $old->query('select * from imghost WHERE news = 1 ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO image
			SET
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			image = \''.$donnees['img'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			type_image_id = 4
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
	$result = $old->query('select * from img_album ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO image
			SET
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			image = \''.$donnees['img'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			type_image_id = 5
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
	$result = $old->query('select * from img_article ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO image
			SET
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			image = \''.$donnees['img'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			type_image_id = 2
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
	$result = $old->query('select * from img_swagg ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO image
			SET
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			image = \''.$donnees['img'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			type_image_id = 6
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}
if(in_array('carousel', $tab)){
	$new->query('DELETE FROM carousel') or die("Error " . mysqli_error());
	$result = $old->query('select * from panell ORDER BY id_panell ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO carousel
			SET
			section_id = \''.$donnees['id_section_panell'].'\',
			type_article_id = \''.$donnees['id_type_article'].'\',
			article_id = \''.mysqli_real_escape_string($new,stripslashes($donnees['id_article'])).'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_panell'])).'\',
			image = \''.mysqli_real_escape_string($new,stripslashes($donnees['image_panell'])).'\',
			lien = \''.mysqli_real_escape_string($new,stripslashes($donnees['lien_panell'])).'\',
			description = \''.mysqli_real_escape_string($new,stripslashes($donnees['desc_panell'])).'\'
			';
		//echo $req.'</br>';
        $new->query($req) or die("Error on request : " . $req . " - " . mysqli_error($new));
	}
}
echo 'ok';
?>