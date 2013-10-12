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
<nav class="top-bar">
	<ul class="title-area">
		<li class="name">
			<h1><a href="#">Administration Panel</a></h1>
		</li>
		<li class="toggle-topbar menu-icon">
			<a href="#"><span>Menu</span></a>
		</li>
	</ul>

	<section class="top-bar-section">
		<!-- Left Nav Section -->
		<ul class="left">
			<li class="divider"></li>
			<li><a href="#">Users</a></li>
		</ul>

		<!-- Right Nav Section -->
		<ul class="right">
			<li class="divider hide-for-small"></li>
			<li class="has-dropdown hide-for-small"><a href="#">Navigation</a>
				<ul class="dropdown">
					<li><label>Administration</label></li>
					<li class="has-dropdown"><a href="#" class="">Pages</a>
						<ul class="dropdown">
							<li><a href="#">Pages list</a></li>
							<li class="divider"></li>
							<li><a href="#">Latest page created</a></li>
						</ul>
					</li>
					<li class="has-dropdown"><a href="users.php" class="">Users</a>
						<ul class="dropdown">
							<li><a href="users.php">Users list</a></li>
							<li><a href="#">Users lists, by activity</a></li>
							<li class="divider"></li>
							<li><a href="#">Latest user created</a></li>
						</ul>
					</li>
					<li class="divider"></li>
					<li><label>Fast Options</label></li>
					<li><a href="#">Create new page</a></li>
					<li><a href="#">Create new user</a></li>
					<li><a href="#">See charts</a></li>
					<li class="divider"></li>
					<li><a href="index.php">See all &rarr;</a></li>
				</ul>
			</li>
			<li class="divider"></li>
			<li class="has-form">
				<a class="button" target="_blank" href="index.php?visitor">Go to the website</a>
			</li>
			<li class="has-form">
				<a class="button alert" href="logout.php">Quit and logout</a>
			</li>
		</ul>
	</section>
</nav>

