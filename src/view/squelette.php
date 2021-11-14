<!DOCTYPE html>
<html lang="fr">

<head>
	<title><?php echo $this->title; ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="CSS/style.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&family=Raleway:wght@600&display=swap" rel="stylesheet">

</head>

<body>
	<header>
		<nav>
			<ul class="nav">
				<?php
				foreach ($this->getMenu() as $texte => $lien) {
					echo '<li><a href="' . $lien . '">' . $texte . '</a></li>';
				}
				echo '<li class="menu"><a href="#">Compte</a>';
				echo '<ul class="sousMenu">';
				foreach ($this->getSousMenu() as $texte => $lien) {
					echo '<li><a href="' . $lien . '">' . $texte . '</a></li>';
				}
				echo '</ul>';
				echo '</li>';
				?>
			</ul>
		</nav>
		<h1>Kitchy Cootchen</h1>
		<form id="recherche" method="GET">
			<input type="text" name="recherche" size="30" placeholder="Rechercher une recette" required="required">
		</form>
	</header>
	<main>
		<div class="content">
			<h2><?php echo $this->title; ?></h2>
			<?php echo $this->content; ?>
		</div>
	</main>
	<footer><?php echo '<a href="' . $this->router->getAProposURL() . '">À propos</a>'; ?></footer>

</body>

</html>