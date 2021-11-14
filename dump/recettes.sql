-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql.info.unicaen.fr:3306
-- Généré le : Dim 14 nov. 2021 à 17:03
-- Version du serveur :  10.5.11-MariaDB-1
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `21903735_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

CREATE TABLE `recettes` (
  `id` int(11) NOT NULL,
  `utilisateur` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `recette` text DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `recettes`
--

INSERT INTO `recettes` (`id`, `utilisateur`, `titre`, `recette`, `image`) VALUES
(17, 'vanier', 'Gâteau au chocolat', 'Préchauffez votre four à 180°C (thermostat 6). Dans une casserole, faites fondre le chocolat et le beurre coupé en morceaux à feu très doux. Dans un saladier, ajoutez 100g de sucre, 3 de oeufs, 50g farine. Mélangez. Ajoutez le mélange des 200g de chocolat pâtissier et des 100g de beurre, mélangez bien. Beurrez et farinez votre moule puis y versez la pâte à gâteau. Faites cuire au four environ 20 minutes. A la sortie du four le gâteau ne paraît pas assez cuit. Ce qui est normal, laissez-le refroidir puis démoulez- le.', '6191028d3992bgateau.jpg'),
(18, 'lecarpentier', 'Crêpes', '1 . Mettez la farine dans un saladier avec le sel et le sucre. 2. Faites un puits au milieu et versez-y les œufs. 3. Commencez à mélanger doucement. Quand le mélange devient épais, ajoutez le lait froid petit à petit. 4. Quand tout le lait est mélangé, la pâte doit être assez fluide. Si elle vous paraît trop épaisse, rajoutez un peu de lait. Ajoutez ensuite le beurre fondu refroidi, mélangez bien. 5. Faites cuire les crêpes dans une poêle chaude (par précaution légèrement huilée si votre poêle à crêpes n\'est pas anti-adhésive). Versez une petite louche de pâte dans la poêle, faites un mouvement de rotation pour répartir la pâte sur toute la surface. Posez sur le feu et quand le tour de la crêpe se colore en roux clair, il est temps de la retourner. 6. Laissez cuire environ une minute de ce côté et la crêpe est prête. Et pour finir, répétez jusqu\'à épuisement de la pâte. ', '619103066e3ddcrepe.jpg'),
(19, 'lecarpentier', 'Quiche Lorraine', 'Préchauffez le four à 180°C. Pendant ce temps, garnissez un moule avec la pâte à tarte puis piquez-la à l’aide d’une fourchette de part en part. Dans une poêle faites dorer les lardons. J’aime quand ils sont bien grillés. Egouttez le gras de cuisson. Mélangez dans un saladier les œufs, la crème, le lait. Puis, ajoutez le poivre, une pincée de muscade. Et enfin, rajoutez les lardons. Mélangez puis versez sur la pâte. Cuisez 45 à 50 minutes au four thermostat 6 (180°C). Servez avec une petite salade verte, un régal !', '6191034e521abquiche_lorraine.jpg'),
(20, 'vanier', 'Gratin de pommes de terre', '1) Épluchez et coupez en fines rondelles les pommes de terre. 2) Frottez le plat à gratin avec la gousse d\'ail. 3) Disposez successivement les rondelles de pommes de terre, le gruyère râpé et la crème, salez et poivrez. Recommencez jusqu\'en haut du plat pour finir sur une couche de pommes de terre. 4) Ajoutez une noix de beurre. 5) Faites cuire à 200°C (Thermostat 6) pendant 50 min puis 5 min à 240°C (Thermostat 8). 6) Dégustez aussitôt.', '6191039055a9cgratin_de_pommes_de_terre.jpeg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
