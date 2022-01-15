SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

USE `app`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `user_city` (
  `id` int NOT NULL,
  `city_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
  
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `user_city`
  ADD PRIMARY KEY (`id`),
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `user_city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

INSERT INTO `users` (`email`, `password`, `name`) VALUES
('teste@email.com', '$2y$10$4encp2Dt.faI/TQXtTh6AOsbVM2L4m2569ijJ6RbF13Kto0IYnPqu', 'Teste');

SET @last_insert_id = LAST_INSERT_ID();

INSERT INTO `user_city` (`city_id`, `user_id`) VALUES
(1, @last_insert_id);

INSERT INTO `users` (`email`, `password`, `name`) VALUES
('teste_a@email.com', '$2y$10$sLK87PdKkVe4GkWIb4eqz.IrhTa7XMZLF2r6qno29CivgEyenzfD2', 'Teste A');

SET @last_insert_id = LAST_INSERT_ID();

INSERT INTO `user_city` (`city_id`, `user_id`) VALUES
(1, @last_insert_id);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

