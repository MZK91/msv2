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
	'images',
	'carousel',
	'article'
	);

$hostname = '127.0.0.1';
$username = 'root';
$password = '';

$old = mysqli_connect($hostname, $username, $password , "muzikspirit") or die("Error " . mysqli_error($old));
$new = mysqli_connect($hostname, $username, $password , "mzkv2") or die("Error " . mysqli_error($new)); 

if(in_array('albums', $tab)){
	$new->query('TRUNCATE album') or die("Error " . mysqli_error());
	$result = $old->query('select * from albums ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO album
			SET
			id = \''.$donnees['id'].'\',
			section_id = \''.$donnees['id_section'].'\',
			user_id = \''.$donnees['id_user'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			album = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			tracklist = \''.mysqli_real_escape_string($new,stripslashes($donnees['tracklist_album'])).'\',
			vues = \''.$donnees['vues'].'\',
			vues_dif = \''.$donnees['vues_dif'].'\',
			cover = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			last_ip = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error " . mysqli_error($new));
	}
	$result = $old->query('select * from sorties_albums ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) {
		if($donnees['id_album'] != 0){
			$req = '
			UPDATE album
			SET
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['nom_artiste'])).'\',
			album = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_album'])).'\',
			dateSortie = \''.date("Y-m-d H:i:s",$donnees['date_sortie']).'\',
			mixtape = \''.$donnees['mixtape'].'\'
			WHERE id = \''.$donnees['id_album'].'\'
			';
			//echo $req.'</br>';
			$new->query($req) or die("Error " . mysqli_error($new));
		}
	}
}

if(in_array('artistes', $tab)){
	$new->query('TRUNCATE artiste') or die("Error " . mysqli_error());
	$result = $old->query('select * from artistes ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO artiste
			SET
			idSection = \''.$donnees['id_section'].'\',
			idUser = \''.$donnees['id_user'].'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}

if(in_array('clips', $tab)){
	$new->query('TRUNCATE clip') or die("Error " . mysqli_error());
	$result = $old->query('select * from clips ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO clip
			SET
			idSection = \''.$donnees['id_section'].'\',
			idUser = \''.$donnees['id_user'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			featuring = \''.mysqli_real_escape_string($new,stripslashes($donnees['featuring'])).'\',
			son = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}

if(in_array('lifestyle', $tab)){
	$new->query('TRUNCATE lifestyle') or die("Error " . mysqli_error());
	$result = $old->query('select * from swagg ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO lifestyle
			SET
			idUser = \''.$donnees['id_user'].'\',
			idType = \''.$donnees['id_type_cat'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}

if(in_array('lyrics', $tab)){
	$new->query('TRUNCATE lyrics') or die("Error " . mysqli_error());
	$result = $old->query('select * from lyrics ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO lyrics
			SET
			id = \''.$donnees['id'].'\',
			idSection = \''.$donnees['id_section'].'\',
			idUser = \''.$donnees['id_user'].'\',
			idAlbum = \''.$donnees['id_album'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			featuring = \''.mysqli_real_escape_string($new,stripslashes($donnees['featuring'])).'\',
			son = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			media = \''.$donnees['media'].'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error " . mysqli_error($new));
	}
}
if(in_array('news', $tab)){
	$new->query('TRUNCATE news') or die("Error " . mysqli_error());
	$result = $old->query('select * from news ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO news
			SET
			id = \''.$donnees['id'].'\',
			idSection = \''.$donnees['id_section'].'\',
			idUser = \''.$donnees['id_user'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			thumbNews = \''.mysqli_real_escape_string($new,stripslashes($donnees['thumbnail_news'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error " . mysqli_error($new));
	}
}

if(in_array('sons', $tab)){
	$new->query('TRUNCATE son') or die("Error " . mysqli_error());
	$result = $old->query('select * from sons ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO son
			SET
			idSection = \''.$donnees['id_section'].'\',
			idUser = \''.$donnees['id_user'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			featuring = \''.mysqli_real_escape_string($new,stripslashes($donnees['featuring'])).'\',
			son = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_son'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}

if(in_array('videos', $tab)){
	$new->query('TRUNCATE video') or die("Error " . mysqli_error());
	$result = $old->query('select * from videos ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO video
			SET
			idSection = \''.$donnees['id_section'].'\',
			idUser = \''.$donnees['id_user'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			artiste = \''.mysqli_real_escape_string($new,stripslashes($donnees['artiste'])).'\',
			media = \''.mysqli_real_escape_string($new,stripslashes($donnees['media'])).'\',
			texte = \''.mysqli_real_escape_string($new,stripslashes($donnees['texte'])).'\',
			vues = \''.$donnees['vues'].'\',
			vuesDif = \''.$donnees['vues_dif'].'\',
			image = \''.$donnees['photo'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			duration = \''.$donnees['duration'].'\',
			facebook = \''.$donnees['facebook'].'\',
			twitter = \''.$donnees['twitter'].'\',
			lastIp = \''.$donnees['last_ip'].'\',
			lastVisit = \''.date("Y-m-d H:i:s",$donnees['last_visit']).'\',
			likes = \''.$donnees['likes'].'\',
			dislikes = \''.$donnees['dislikes'].'\',
			score = \''.$donnees['score'].'\',
			ip = \''.$donnees['ip'].'\',
			slug = \''.title_to_url(stripslashes($donnees['titre'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}
if(in_array('images', $tab)){
	$new->query('TRUNCATE image') or die("Error " . mysqli_error());
	$result = $old->query('select * from imghost WHERE news = 0 ORDER BY id ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO image
			SET
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre'])).'\',
			image = \''.$donnees['img'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date']).'\',
			idTypeImage = 0
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
			idTypeImage = 4
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
			idTypeImage = 5
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
			idTypeImage = 2
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
			idTypeImage = 6
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}
if(in_array('carousel', $tab)){
	$new->query('TRUNCATE carousel') or die("Error " . mysqli_error());
	$result = $old->query('select * from panell ORDER BY id_panell ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO carousel
			SET
			idSection = \''.$donnees['id_section_panell'].'\',
			idType = \''.$donnees['id_type_article'].'\',
			idArticle = \''.mysqli_real_escape_string($new,stripslashes($donnees['id_article'])).'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_panell'])).'\',
			image = \''.mysqli_real_escape_string($new,stripslashes($donnees['image_panell'])).'\',
			lien = \''.mysqli_real_escape_string($new,stripslashes($donnees['lien_panell'])).'\',
			description = \''.mysqli_real_escape_string($new,stripslashes($donnees['desc_panell'])).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}
if(in_array('article', $tab)){
	$new->query('TRUNCATE article') or die("Error " . mysqli_error());
	$result = $old->query('select * from articles ORDER BY id_article ASC'); 
	while($donnees = mysqli_fetch_array($result)) { 
		$req = '
			INSERT INTO article
			SET
			idArticle = \''.$donnees['id_article_table'].'\',
			idSection = \''.$donnees['id_section'].'\',
			idType = \''.$donnees['id_type_article'].'\',
			exclu = \''.$donnees['exclu'].'\',
			titre = \''.mysqli_real_escape_string($new,stripslashes($donnees['titre_article'])).'\',
			immanquable = \''.$donnees['immanquable'].'\',
			image = \''.$donnees['photo_article'].'\',
			date = \''.date("Y-m-d H:i:s",$donnees['date_article']).'\'
			';
		//echo $req.'</br>';
		$new->query($req) or die("Error ".$req." - ". mysqli_error($new));
	}
}
echo 'ok';
?>