-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2021 at 07:07 PM
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
  `name` varchar(255) DEFAULT NULL,
  `comment_text` varchar(290) DEFAULT NULL,
  `date_created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `P_ID`, `name`, `comment_text`, `date_created`) VALUES
(1, 9, 'sunday fadeyi', 'This is a test comment', '2021-09-13'),
(2, 9, 'Ikedinobi Onyeka', 'Nigga spitting wisdom here and there', '2021-09-13'),
(3, 9, 'Mike James', 'This is the first twist of sweet alert', '2021-09-13'),
(4, 9, 'Mark Barnes', 'Another test before going to bed!', '2021-09-13'),
(5, 9, 'sunday fadeyi', 'Another comment test', '2021-09-13'),
(6, 9, 'sunday fadeyi', 'afhsdjfhlaskdjfhalsdjfhalsdkfjahdlskfadf', '2021-09-15'),
(7, 9, 'sunday fadeyi', 'something fishy going on', '2021-09-16'),
(8, 11, 'sunday fadeyi', 'Another test of tenacity', '2021-09-18'),
(9, 12, 'syhgfsbfhzgodf', 'hgefsnjkgsduktsdt', '2021-09-20'),
(10, 8, 'Mark Zuckerberg', 'I\'m currently endorsing and funding bobblenote yay!', '2021-09-21'),
(11, 12, 'sunday fadeyi', 'jljkljkbljbljhbhbljiuyguvgjkhkjhkjhkjhkjhvk;;klj;lklklk;;kklj;', '2021-09-22'),
(12, 12, 'Mike thompson', 'I\'m sharing my thoughts', '2021-09-24'),
(13, 11, 'King Jacob', 'Such a nice work King, You\'re doing good!', '2021-11-12'),
(14, 16, 'King Jacob', 'something hooge is coming', '2021-11-20'),
(15, 16, 'King Jacob', 'I\'m testing this module frequently', '2021-11-20'),
(16, 16, 'King D-King', 'Gotta love data manipulation', '2021-11-20'),
(17, 8, 'King Jacob', 'This is a really nice concept', '2021-11-22'),
(18, 16, 'King Jacob', 'another test today again. We\'re going hard!', '2021-11-23'),
(19, 12, 'King Jacob', 'something', '2021-11-24'),
(20, 10, 'King Jacob', 'Yup Elon Musk has to be the boss of them all!', '2021-11-26');

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
(1, 'Bobblenote competition', 'bobblenote', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '<ul>\r\n<li>someuwe paosid fpsidper sioi a spiderman is a man</li>\r\n<li>spiderman is a spoidfe owon oseu spidernbai</li>\r\n<li>soiew oan tbo aown doa</li>\r\n<li>soienw pwiefns be a good person</li>\r\n</ul>', '<ul>\r\n<li>someuwe paosid fpsidper sioi a spiderman is a man</li>\r\n<li>spiderman is a spoidfe owon oseu spidernbai</li>\r\n<li>soiew oan tbo aown doa</li>\r\n<li>soienw pwiefns be a good person</li>\r\n</ul>', '2021-12-17', '2021-12-25', '2021-12-14', 'kingsjacobfrancis@gmail.com', 'ongoing', 9000),
(2, 'Penactive Competition', 'penactive', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '<ul>\r\n<li>adfadfadfasdfadfasd</li>\r\n<li>adfasdfasdfdsf</li>\r\n<li>sdfasdadfadf</li>\r\n<li>dfadfasdfadf</li>\r\n</ul>', '<ul>\r\n<li>adfadfadfasdfadfasd</li>\r\n<li>adfasdfasdfdsf</li>\r\n<li>sdfasdadfadf</li>\r\n<li>dfadfasdfadf</li>\r\n</ul>', '2021-12-17', '2021-12-30', '2021-12-14', 'kingsjacobfrancis@gmail.com', 'ongoing', 90000);

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
(159, 12, 'kingsjacobfrancis@gmail.com'),
(162, 11, 'kingsjacobfrancis@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `part_ID` int(11) NOT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `comp_ID` int(11) DEFAULT NULL,
  `date_joined` date DEFAULT current_timestamp(),
  `part_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `participants_dump`
--

CREATE TABLE `participants_dump` (
  `part_ID` int(11) DEFAULT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `comp_ID` int(11) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `part_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(8, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-082121108284.png', 'Introduction to business administration', 'Education', 'superman,business,politics', '<p>Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. <strong>Various versions have evolved over</strong> the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<h4>SOME FUNNY LIST</h4>\r\n<ul>\r\n<li>superman</li>\r\n<li>spiderman</li>\r\n<li>batman</li>\r\n<li>ironman</li>\r\n<li>John cena</li>\r\n</ul>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>&nbsp;</p>', 'Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evol', 'yes', 4, 2, '2021-09-08'),
(9, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-08970707698.png', 'Technology in the new age and it\'s advancement', 'Software', 'superman,business,politics', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>It is a long established fact that a <strong>reader will be distracted by the readable content </strong>of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>\r\n<p>&nbsp;</p>', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem ', 'yes', 3, 7, '2021-09-08'),
(10, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-08392111402.png', 'Automobile industry business tycoons', 'Education', 'superman,business,politics', '<div>\r\n<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. Nobis voluptates repellendus incidunt eaque reiciendis accusantium molestias ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur incidunt accusantium eligendi excepturi tempora a, nesciunt eaque nam totam. Cumque, neque! Quas tempora maxime eius quam ea! Inventore, suscipit vero.\r\n<div>\r\n<div><strong>Lorem ipsum</strong> dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. Nobis voluptates repellendus incidunt eaque reiciendis accusantium molestias ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur incidunt accusantium eligendi excepturi tempora a, nesciunt eaque nam totam. Cumque, neque! Quas tempora maxime eius quam ea! Inventore, suscipit vero.</div>\r\n</div>\r\n</div>\r\n</div>', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. ', 'yes', 3, 1, '2021-09-08'),
(11, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-081489592566.png', 'Desert biking rules for 2021', 'Sports', 'superman,business,politics', '<div>\r\n<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. Nobis voluptates repellendus incidunt eaque reiciendis accusantium molestias ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur incidunt accusantium eligendi excepturi tempora a, nesciunt eaque nam totam. Cumque, neque! Quas tempora maxime eius quam ea! Inventore, suscipit vero.</div>\r\n</div>', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque error incidunt ipsam facere? Neque sit odio expedita quae, nostrum ipsam accusamus. ', 'yes', 3, 2, '2021-09-08'),
(12, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-09-081724339386.png', 'Women in top technological industries', 'Software', 'finance,tech,business', '<div>\r\n<div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit praesentium quidem officiis labore recusandae ipsa ad, rem tempora unde repellat repellendus iure provident vitae sit, minima tenetur exercitationem quod. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, similique sunt! Nam eligendi voluptates placeat quaerat dolore assumenda deserunt. Asperiores unde vel architecto dolorum quas. Iste dolores laborum expedita libero?</div>\r\n</div>', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit praesentium quidem officiis labore recusandae ipsa ad, rem tempora unde re', 'yes', 7, 4, '2021-09-08'),
(16, 'kingsjacobfrancis@gmail.com', 'images/posts/kingsjacobfrancis@gmail.com2021-11-11410546440.png', 'How Meta CEO observes his daily routine.', 'Technology', 'tech,software,lifestyle', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<h5>Code Example</h5>\r\n<pre class=\"language-php\"><code>function sayHello($num){\r\n  for($i = 0; $i < $num; $i++){\r\n     echo \"Hello King\";\r\n  }\r\n echo \"How are you today\";\r\n}</code></pre>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the likess). here in the world</p>\r\n<p> </p>', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem ', 'yes', 0, 4, '2021-11-24');

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
(6, 'debit', 'Bobblenote', 'kingsjacobfrancis@gmail.com', 90000, '2021-12-14');

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
(7, '', '', 'King', 'Jacob', 'kingsjacobfrancis@gmail.com', '09017259065', '2021-09-23', '<p>Hey there, I\'m a writer who loves to create and share interesting and educative content..😜✈️</p>', 'images/other/kingsjacobfrancis@gmail.com.png', 0, '', 'https://www.instagram.com/kingx_x628/', 'https://www.linkedin.com/in/king-jacob-a184a21b2', 'https://web.facebook.com/king.jacob.1238/', 'no', '$2y$10$MQkD0vNgNTVl8ZRhHxhzUe7EsZm3Q8UvdrHyVEYIoXV3fbooZQehq', 'yes', 'yes', 'AsQmKbk', '2021-09-05'),
(14, '', '', 'Mike', 'Pence', 'fayeoforijacob46@gmail.com', '9017259065', '2021-10-19', '<p>😊Hey there, I\'m a writer</p>', 'images/other/default_dp.svg', 0, 'twitter url', 'instagram url', 'linkedin url', 'facebook url', 'no', '$2y$10$OUUdjv18KxvPJgZxwwY3.OnX9jUU47pS905pQ78sIWsNYtcQ9Sa4C', 'yes', 'yes', '9Grh0oiFD', '2021-10-22');

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
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `comp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `L_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `part_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `writers`
--
ALTER TABLE `writers`
  MODIFY `W_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
