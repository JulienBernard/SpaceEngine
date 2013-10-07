<!DOCTYPE html>

<html lang="fr">
<head>

	<!--	SpaceEngine Copyright (C) 2013 Julien Bernard
			SpaceEngine is a free website engine under GPL license!
			Site propulsé sous le moteur de site web libre, le SpaceEngine.	-->

	<title><?php echo DEFAULT_TITLE.$Template->getTitle(); ?></title>
	<meta charset="utf-8" />
	<meta name="google-site-verification" content="v2Ddq6qw70xR2UAFJGCzfMQhrB-gJQDQjaRlS1J2dts" /> 
	<meta name="Author" lang="fr" content="Julien BERNARD">
	<meta name="Publisher" content="Julien BERNARD">
	
	<base href="<?php echo BASE_SITE; ?>" />
	
	<?php
		// Chargement de la description
		$rt = $Template->getDescription();
		if( !empty( $rt ) )
		{
			echo '<meta name="description" content="'.$Template->getDescription().'" />
			';
		}
		else
		{
			echo '<meta name="description" content="'.DEFAULT_DESCRIPTION.'" />
			';
		}
		
		// Chargement des CSS
		foreach( $Template->getCss() as $css )
		{
			echo '<link rel="stylesheet" media="screen" href="css/'.$css.'" />
			';
		}
	
		// Chargement des scripts
		foreach( $Template->getScript() as $script )
		{
			echo '<script type="text/javascript" src="./js/'.$script.'"></script>
			';
		}
	?>

</head>

<body>
	<!--
	<p>
			<span id="SmallOne">JULIEN BERNARD présente SpaceEngine, un moteur web imaginé pour <a href="http://www.apocalyspace.fr">www.apocalyspace.fr</a></span>
			SpaceEngine : moteur de site internet, simple et rapide !<br />
			<span id="SmallTwo">PHP5 - ORIENTE OBJET - PDO - PATTERN MVC</span>
		</p>
		-->
	<header id="header">
		<h1>SpaceEngine</h1>
		<p>A FREE AND OPEN-SOURCE ENGINE, FOR PHP5 WEBSITE</p>
	
		<a href="https://github.com/JulienBernard/SpaceEngine" class="alert button radius">Source</a>
		<a href="" class="success button radius">Download the latest version (1.0)</a>
		<a href="" class="button radius">Try it!</a>
	
		<nav class="navigation">
			<a href="#" class="toWhat">What, Why, Who</a><a href="#" class="toTutorial">Getting started</a><a href="#" class="toFollow">Follow / Fork</a>
		</nav>
	</header>

