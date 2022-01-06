-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2022 at 08:09 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acute`
--

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `pos_ID` int(11) NOT NULL,
  `comp_ID` int(11) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `postion` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `category`) VALUES
(1, 'Education'),
(3, 'Sports'),
(4, 'Politics'),
(5, 'Technology'),
(6, 'Business'),
(7, 'Fashion'),
(8, 'Cooking'),
(9, 'Health');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `P_ID` int(11) DEFAULT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `comment_text` varchar(290) DEFAULT NULL,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `P_ID`, `u_email`, `comment_text`, `date_created`) VALUES
(30, 16, 'kingsjacobfrancis@gmail.com', 'Testing the first comment simulation 💀', '2021-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `comp_ID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `comp_description` mediumtext DEFAULT NULL,
  `requirements` mediumtext DEFAULT NULL,
  `rules` mediumtext DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `date_created` date DEFAULT current_timestamp(),
  `u_email` varchar(255) DEFAULT NULL,
  `comp_status` varchar(255) DEFAULT NULL,
  `total_deposit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`comp_ID`, `name`, `tag`, `comp_description`, `requirements`, `rules`, `start_date`, `end_date`, `date_created`, `u_email`, `comp_status`, `total_deposit`) VALUES
(1, 'Bobblenote competition', 'bobblenote', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)😝</p>', '<ul>\r\n<li>someuwe paosid fpsidper sioi a spiderman is a man</li>\r\n<li>spiderman is a spoidfe owon oseu spidernbai</li>\r\n<li>soiew oan tbo aown doa</li>\r\n<li>soienw pwiefns be a good person</li>\r\n</ul>', '<ul>\r\n<li>someuwe paosid fpsidper sioi a spiderman is a man</li>\r\n<li>spiderman is a spoidfe owon oseu spidernbai</li>\r\n<li>soiew oan tbo aown doa</li>\r\n<li>soienw pwiefns be a good person</li>\r\n</ul>', '2022-01-03', '2022-01-08', '2021-12-14', 'kingsjacobfrancis@gmail.com', 'ongoing', 45000),
(2, 'Penactive Competition', 'penactive', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search.</p>', '<ul>\r\n<li>adfadfadfasdfadfasd</li>\r\n<li>adfasdfasdfdsf</li>\r\n<li>sdfasdadfadf</li>\r\n<li>dfadfasdfadf</li>\r\n</ul>', '<ul>\r\n<li>adfadfadfasdfadfasd</li>\r\n<li>adfasdfasdfdsf</li>\r\n<li>sdfasdadfadf</li>\r\n<li>dfadfasdfadf</li>\r\n</ul>', '2022-01-08', '2022-01-16', '2021-12-14', 'kingsjacobfrancis@gmail.com', 'ongoing', 90000),
(3, 'Test competition', 'testcomp', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '<ul>\r\n<li>someuwe paosid fpsidper sioi a spiderman is a man</li>\r\n<li>spiderman is a spoidfe owon oseu spidernbai</li>\r\n<li>soiew oan tbo aown doa</li>\r\n<li>soienw pwiefns be a good person</li>\r\n</ul>', '<ul>\r\n<li>someuwe paosid fpsidper sioi a spiderman is a man</li>\r\n<li>spiderman is a spoidfe owon oseu spidernbai</li>\r\n<li>soiew oan tbo aown doa</li>\r\n<li>soienw pwiefns be a good person</li>\r\n</ul>', '2021-12-23', '2021-12-31', '2021-12-21', 'kingsjacobfrancis@gmail.com', 'expired', 45000),
(7, 'New competition', 'newcomp', '<p>\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"</p>', '<ul>\r\n<li>t explain to you how all this mistaken idea of denouncing pleasure a</li>\r\n<li>t explain to you how all this mistaken idea of denouncing pleasure a</li>\r\n<li>t explain to you how all this mistaken idea of denouncing</li>\r\n</ul>', '<ul>\r\n<li>t explain to you how all this mistaken idea of denouncing pleasure a</li>\r\n<li>t explain to you how all this mistaken idea of denouncing pleasure a</li>\r\n<li>t explain to you how all this mistaken idea of denouncing</li>\r\n</ul>', '2022-01-03', '2022-01-14', '2021-12-30', 'kingsjacobfrancis@gmail.com', 'ongoing', 45000),
(8, 'Pubbleplace competition', 'pubbleplace', '<p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains</p>', '<ul>\r\n<li>something goes here first</li>\r\n<li>second thing is happening now</li>\r\n<li>Also learn to be good to others</li>\r\n</ul>', '<ul>\r\n<li>something goes here first</li>\r\n<li>second thing is happening now</li>\r\n<li>Also learn to be good to others</li>\r\n<li>Learn to work hard and chase your dreams</li>\r\n</ul>', '2022-01-12', '2022-01-19', '2022-01-06', 'kingsjacobfrancis@gmail.com', 'ongoing', 450000);

-- --------------------------------------------------------

--
-- Table structure for table `email_list`
--

CREATE TABLE `email_list` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_list`
--

INSERT INTO `email_list` (`ID`, `email`, `date`) VALUES
(14, 'kingsjacobfrancis@gmail.com', '2021-11-15');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `F_ID` int(11) NOT NULL,
  `date_created` varchar(255) DEFAULT NULL,
  `writer` varchar(255) DEFAULT NULL,
  `follower` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `house_posts`
--

CREATE TABLE `house_posts` (
  `H_ID` int(11) NOT NULL,
  `coverimg` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `excerpt` varchar(255) DEFAULT NULL,
  `published` varchar(12) DEFAULT NULL,
  `no_of_likes` int(11) DEFAULT NULL,
  `no_of_comments` int(11) DEFAULT NULL,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `house_posts`
--

INSERT INTO `house_posts` (`H_ID`, `coverimg`, `title`, `category`, `tags`, `content`, `excerpt`, `published`, `no_of_likes`, `no_of_comments`, `date_created`) VALUES
(1, 'images/posts/kingsjacobfrancis@gmail.com2021-09-081724339386.png', 'Women in top technological industries', 'Technology and software', 'finance,tech,business', '<div>\r\n<div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit praesentium quidem officiis labore recusandae ipsa ad, rem tempora unde repellat repellendus iure provident vitae sit, minima tenetur exercitationem quod. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, similique sunt! Nam eligendi voluptates placeat quaerat dolore assumenda deserunt. Asperiores unde vel architecto dolorum quas. Iste dolores laborum expedita libero?</div>\r\n</div>', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit praesentium quidem officiis labore recusandae ipsa ad, rem tempora unde re', 'yes', 0, 0, '2021-09-11');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `L_ID` int(11) NOT NULL,
  `P_ID` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`L_ID`, `P_ID`, `email`) VALUES
(156, 8, 'kingsjacobfrancis@gmail.com'),
(158, 10, 'kingsjacobfrancis@gmail.com'),
(167, 11, 'kingsjacobfrancis@gmail.com'),
(169, 17, 'kingsjacobfrancis@gmail.com'),
(170, 16, 'kingsjacobfrancis@gmail.com'),
(171, 12, 'kingsjacobfrancis@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `part_ID` int(11) NOT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `comp_ID` int(11) DEFAULT NULL,
  `date_joined` date DEFAULT current_timestamp(),
  `part_status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`part_ID`, `u_email`, `comp_ID`, `date_joined`, `part_status`) VALUES
(10, 'kingsjacobfrancis@gmail.com', 3, '2021-12-26', 'verified'),
(11, 'fayeoforijacob46@gmail.com', 3, '2021-12-27', 'verified'),
(14, 'kingsjacobfrancis@gmail.com', 7, '2021-12-31', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `participants_dump`
--

CREATE TABLE `participants_dump` (
  `part_ID` int(11) NOT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `comp_ID` int(11) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `part_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participants_dump`
--

INSERT INTO `participants_dump` (`part_ID`, `u_email`, `comp_ID`, `date_joined`, `part_status`) VALUES
(8, 'kingsjacobfrancis@gmail.com', 2, '2021-12-28', 'verified'),
(12, 'kingsjacobfrancis@gmail.com', 1, '2021-12-30', 'disqualified'),
(13, 'fayeoforijacob46@gmail.com', 1, '2021-12-30', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `P_ID` int(11) NOT NULL,
  `W_email` varchar(255) DEFAULT NULL,
  `coverimg` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `excerpt` varchar(255) NOT NULL,
  `published` varchar(255) NOT NULL DEFAULT 'no',
  `no_of_likes` int(11) NOT NULL,
  `no_of_comments` int(11) NOT NULL,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`P_ID`, `W_email`, `coverimg`, `title`, `category`, `tags`, `content`, `excerpt`, `published`, `no_of_likes`, `no_of_comments`, `date_created`) VALUES
(8, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-082121108284.png', 'Introduction to business administration', 'Education', 'superman,business,politics', '<p>Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. <strong>Various versions have evolved over</strong> the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<h4>SOME FUNNY LIST</h4>\r\n<ul>\r\n<li>superman</li>\r\n<li>spiderman</li>\r\n<li>batman</li>\r\n<li>ironman</li>\r\n<li>John cena</li>\r\n</ul>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>&nbsp;</p>', 'Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evol', 'yes', 4, 0, '2021-09-08'),
(9, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-08970707698.png', 'Technology in the new age and it\'s advancement', 'Software', 'superman,business,politics', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>It is a long established fact that a <strong>reader will be distracted by the readable content </strong>of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>&nbsp;</p>', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem ', 'yes', 3, 0, '2021-09-08'),
(10, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-08392111402.png', 'Automobile industry business tycoons', 'Education', 'superman,business,politics', '<div>\r\n<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. Nobis voluptates repellendus incidunt eaque reiciendis accusantium molestias ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur incidunt accusantium eligendi excepturi tempora a, nesciunt eaque nam totam. Cumque, neque! Quas tempora maxime eius quam ea! Inventore, suscipit vero.\r\n<div>\r\n<div><strong>Lorem ipsum</strong> dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. Nobis voluptates repellendus incidunt eaque reiciendis accusantium molestias ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur incidunt accusantium eligendi excepturi tempora a, nesciunt eaque nam totam. Cumque, neque! Quas tempora maxime eius quam ea! Inventore, suscipit vero.</div>\r\n</div>\r\n</div>\r\n</div>', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. ', 'yes', 3, 0, '2021-09-08'),
(11, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-081489592566.png', 'Desert biking rules for 2021', 'Sports', 'superman,business,politics', '<div>\r\n<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. Nobis voluptates repellendus incidunt eaque reiciendis accusantium molestias ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur incidunt accusantium eligendi excepturi tempora a, nesciunt eaque nam totam. Cumque, neque! Quas tempora maxime eius quam ea! Inventore, suscipit vero.</div>\r\n</div>', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. ', 'yes', 3, 0, '2021-09-08'),
(12, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-081724339386.png', 'Women in top technological industries', 'Software', 'finance,tech,business', '<div>\r\n<div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit praesentium quidem officiis labore recusandae ipsa ad, rem tempora unde repellat repellendus iure provident vitae sit, minima tenetur exercitationem quod. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, similique sunt! Nam eligendi voluptates placeat quaerat dolore assumenda deserunt. Asperiores unde vel architecto dolorum quas. Iste dolores laborum expedita libero?</div>\r\n</div>', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit praesentium quidem officiis labore recusandae ipsa ad, rem tempora unde re', 'yes', 7, 0, '2021-09-08'),
(16, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-11-11410546440.png', 'How Meta CEO observes his daily routine.', 'Technology', 'tech,software,lifestyle', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<h5>Code Example</h5>\r\n<pre class=\"language-php\"><code>function sayHello($num){\r\n  for($i = 0; $i < $num; $i++){\r\n     echo \"Hello King\";\r\n  }\r\n echo \"How are you today\";\r\n}</code></pre>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the likess). here in the world</p>\r\n<p> </p>', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem ', 'yes', 1, 1, '2021-11-24'),
(17, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-12-241846986838.png', 'Africa\'s future in the fashion industry', 'Fashion', 'fashion,africa,bobblenote,youth', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the', 'yes', 1, 0, '2021-12-24'),
(18, 'fayeoforijacob46@gmail.com', 'images/posts/fayeoforijacob46@gmail.com2021-12-24794663344.png', 'Opportunities for medical practitioners in Canada', 'Health', 'health,business,immigration,bobblenote', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. <strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500', 'yes', 0, 0, '2021-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `T_ID` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `credit` varchar(255) NOT NULL,
  `debit` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`T_ID`, `type`, `credit`, `debit`, `amount`, `date_created`) VALUES
(3, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 9000, '2021-12-14'),
(4, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 9000, '2021-12-14'),
(5, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 900, '2021-12-14'),
(6, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 90000, '2021-12-14'),
(7, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 45000, '2021-12-21'),
(8, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 45000, '2021-12-30'),
(10, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 45000, '2022-01-02'),
(11, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 90000, '2022-01-02'),
(12, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 450000, '2022-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `writers`
--

CREATE TABLE `writers` (
  `W_ID` int(11) NOT NULL,
  `account_type` varchar(20) NOT NULL,
  `organization_name` text NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT 'Hey there, I''m a writer',
  `profilepic` varchar(255) NOT NULL DEFAULT 'images/other/default_dp.svg',
  `no_of_followers` int(11) NOT NULL DEFAULT 0,
  `twitter` varchar(255) NOT NULL DEFAULT 'twitter url',
  `instagram` varchar(255) NOT NULL DEFAULT 'instagram url',
  `linkedin` varchar(255) NOT NULL DEFAULT 'linkedin url',
  `facebook` varchar(255) NOT NULL DEFAULT 'facebook url',
  `verified` varchar(11) NOT NULL DEFAULT 'no',
  `password` varchar(255) DEFAULT NULL,
  `email_verified` varchar(40) NOT NULL DEFAULT 'no',
  `active` varchar(40) NOT NULL DEFAULT 'yes',
  `token` varchar(20) NOT NULL DEFAULT '0000',
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `writers`
--

INSERT INTO `writers` (`W_ID`, `account_type`, `organization_name`, `firstname`, `lastname`, `email`, `mobile`, `dob`, `bio`, `profilepic`, `no_of_followers`, `twitter`, `instagram`, `linkedin`, `facebook`, `verified`, `password`, `email_verified`, `active`, `token`, `date`) VALUES
(7, 'individual', '', 'King', 'Jacob', 'kingsjacobfrancis@gmail.com', '09017259065', '2021-09-23', '<p>Hey there, I\'m a writer who loves to create and share interesting and educative content..😜✈️</p>', 'images/other/kingsjacobfrancis@gmail.com.png', 0, '', 'https://www.instagram.com/kingx_x628/', 'https://www.linkedin.com/in/king-jacob-a184a21b2', 'https://web.facebook.com/king.jacob.1238/', 'no', '$2y$10$1lxHOnXO5h2ATr/WodSudeLFr0aIiORlnH7YoCvj3j6SowKYDXO8q', 'yes', 'yes', 'hxkP0V', '2021-09-05'),
(14, 'individual', '', 'Mike', 'Pence', 'fayeoforijacob46@gmail.com', '9017259065', '2021-10-19', '<p>😊Hey there, I\'m a writer</p>', 'images/other/default_dp.svg', 0, 'twitter url', 'instagram url', 'linkedin url', 'facebook url', 'no', '$2y$10$OUUdjv18KxvPJgZxwwY3.OnX9jUU47pS905pQ78sIWsNYtcQ9Sa4C', 'yes', 'yes', '9Grh0oiFD', '2021-10-22'),
(15, 'organization', 'Bobblenote', '', '', 'bobblenote@gmail.com', '9017259065', '2022-01-20', 'Hey there, I\'m a writer', 'images/other/default_dp.svg', 0, 'twitter url', 'instagram url', 'linkedin url', 'facebook url', 'no', '$2y$10$nOT6a114Acmg2KjpX0WvzeCodqH7Cxhid/Aplr6nTBaQWi36KCBRq', 'yes', 'yes', 'P1N0BETb2Z', '2022-01-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`pos_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`);

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`comp_ID`);

--
-- Indexes for table `email_list`
--
ALTER TABLE `email_list`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`F_ID`);

--
-- Indexes for table `house_posts`
--
ALTER TABLE `house_posts`
  ADD PRIMARY KEY (`H_ID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`L_ID`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`part_ID`);

--
-- Indexes for table `participants_dump`
--
ALTER TABLE `participants_dump`
  ADD PRIMARY KEY (`part_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`P_ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`T_ID`);

--
-- Indexes for table `writers`
--
ALTER TABLE `writers`
  ADD PRIMARY KEY (`W_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `pos_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `comp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `email_list`
--
ALTER TABLE `email_list`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `F_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `house_posts`
--
ALTER TABLE `house_posts`
  MODIFY `H_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `L_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `part_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `writers`
--
ALTER TABLE `writers`
  MODIFY `W_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
