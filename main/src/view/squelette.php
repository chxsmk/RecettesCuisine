<?php
	//session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $this->title; ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="CSS/style.css" />
</head>
<body>
	<header>
		<nav>
			<ul class="nav">
				<li class="menu"><a href="#">Menu</a>
					<ul class="sousMenu">
						<?php
							foreach ($this->getSousMenu() as $text => $link) {
								echo "<li><a href=\"$link\">$text</a></li>";
							}
						?>
					</ul>
				</li>
				<?php
					foreach ($this->getMenu() as $text => $link) {
						echo "<li><a href=\"$link\">$text</a></li>";
					}
				?>
			</ul>
		</nav>
	</header>
	<main>
		<h1><?php echo $this->title; ?></h1>
		<?php echo $this->content;?>
	</main>
</body>
</html>