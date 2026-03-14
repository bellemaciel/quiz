-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 14-Mar-2026 às 18:34
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quiz`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `usuario`, `senha`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `texto_pergunta` text NOT NULL,
  `data_desafio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `perguntas`
--

INSERT INTO `perguntas` (`id`, `tema_id`, `texto_pergunta`, `data_desafio`) VALUES
(1, 1, 'Qual a capital da França?', NULL),
(2, 1, 'Quanto é 2 + 2?', NULL),
(3, 2, 'O que significa a sigla \"HTML\"?', NULL),
(4, 3, 'Em qual das alternativas a seguir o advérbio está incorreto?', NULL),
(6, 3, 'Qual das alternativas apresenta apenas advérbios de tempo?', NULL),
(8, 5, 'Qual o maior animal terrestre ?', NULL),
(9, 6, 'Qual dessas artistas é amplamente conhecida pelo título de \'Rainha do Pop\'?', NULL),
(13, 0, 'Out of these four buildings, which one is the tallest, with a height of 1,483 ft (451.9 m)?', '2026-03-03'),
(14, 0, 'What is the unit of currency in Laos?', '2026-03-03'),
(15, 0, 'What year was Apple Inc. founded?', '2026-03-03'),
(16, 0, 'What is the world\'s most expensive spice by weight?', '2026-03-03'),
(17, 0, 'What is the highest number of Michelin stars a restaurant can receive?', '2026-03-03'),
(18, 6, 'Qual cantora detém o recorde de artista com o maior número de prêmios Grammy na história?', NULL),
(19, 6, 'Qual diva pop iniciou sua carreira como atriz na série da Nickelodeon Victorious?', NULL),
(20, 6, 'Qual álbum de Katy Perry colocou cinco singles no topo da Billboard Hot 100, igualando um recorde de Michael Jackson?', NULL),
(21, 6, 'A The Eras Tour, que se tornou a turnê mais lucrativa de todos os tempos, pertence a qual artista?', NULL),
(22, 7, 'Onde foram realizados os primeiros Jogos Olímpicos da Era Moderna, em 1896?', NULL),
(23, 7, 'O que representam os cinco anéis entrelaçados na bandeira olímpica?', NULL),
(24, 7, 'Quem é o atleta que detém o maior número de medalhas de ouro na história das Olimpíadas?', NULL),
(25, 7, 'Em qual edição dos Jogos Olímpicos o skate e o surf fizeram sua estreia oficial?', NULL),
(26, 8, 'Qual foi o primeiro console de video game doméstico a ser lançado comercialmente no mundo?', NULL),
(27, 8, 'Qual console detém o título de hardware de mesa mais vendido de todos os tempos?', NULL),
(28, 8, 'Em The Legend of Zelda, qual é o nome do reino onde a maioria das aventuras acontece?', NULL),
(29, 8, 'Qual franquia de jogos detém o recorde de mais vendida da história (considerando todos os seus títulos)?', NULL),
(30, 1, 'Qual é o maior oceano do mundo em extensão territorial?', NULL),
(31, 1, 'Qual elemento químico possui o símbolo Au na tabela periódica?', NULL),
(32, 1, 'Qual é o país que possui a maior população do mundo atualmente?', NULL),
(33, 9, 'Qual evento é considerado o estopim imediato para o início da Primeira Guerra Mundial em 1914?', NULL),
(34, 9, 'A Guerra dos Cem Anos, um dos conflitos mais longos da história, foi travada entre quais países?', NULL),
(35, 9, 'Na Segunda Guerra Mundial, o Dia D refere-se a qual evento crucial?', NULL),
(36, 9, 'Como ficou conhecido o período de tensão geopolítica e disputa ideológica entre os EUA e a URSS, sem um confronto militar direto entre eles?', NULL),
(37, 0, 'What do the Dutch call their language?', '2026-03-11'),
(38, 0, 'Which of the following buildings is example of a structure primarily built in the Art Deco architectural style?', '2026-03-11'),
(39, 0, 'Death Valley\'s Badwater Basin is North America\'s point of lowest elevation at how many feet below sea level?', '2026-03-11'),
(40, 0, 'What is the last letter of the Greek alphabet?', '2026-03-11'),
(41, 0, 'This field is sometimes known as &ldquo;The Dismal Science.&rdquo;', '2026-03-11'),
(42, 10, 'Nova pergunta?', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ranking`
--

CREATE TABLE `ranking` (
  `id` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `pontuacao` int(11) NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ranking`
--

INSERT INTO `ranking` (`id`, `nome_usuario`, `pontuacao`, `data_hora`, `usuario_id`) VALUES
(1, 'Isabelle', 2, '2025-11-18 19:53:53', NULL),
(2, 'Joao', 2, '2025-11-18 19:55:09', NULL),
(3, 'Maria', 2, '2025-11-18 22:06:04', NULL),
(4, 'Hello', 2, '2026-02-03 15:38:46', NULL),
(5, 'Luan', 2, '2026-02-03 22:45:19', NULL),
(9, 'Belle', 2, '2026-03-10 23:54:38', 1),
(10, 'Belle', 0, '2026-03-10 23:55:24', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ranking_diario`
--

CREATE TABLE `ranking_diario` (
  `id` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `pontuacao` int(11) NOT NULL,
  `data_obtida` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `pergunta_id` int(11) NOT NULL,
  `texto_resposta` varchar(255) NOT NULL,
  `correta` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id`, `pergunta_id`, `texto_resposta`, `correta`) VALUES
(1, 1, 'Berlim', 0),
(2, 1, 'Paris', 1),
(3, 1, 'Londres', 0),
(4, 1, 'Madri', 0),
(5, 2, '3', 0),
(6, 2, '4', 1),
(7, 2, '5', 0),
(8, 3, 'HyperText Markup Language', 1),
(9, 3, 'High Tech Modern Language', 0),
(10, 3, 'Hyperlink and Text Markup Language', 0),
(11, 4, 'She hasn’t met them yet.', 0),
(13, 4, 'We were rather hot yesterday.', 0),
(15, 4, 'Jamie is waiting for us always.', 1),
(17, 6, 'already, always, then, above', 0),
(18, 6, 'lately, still, next, finaly', 1),
(19, 6, 'first, here, rarely, yet', 0),
(20, 8, 'Elefante-Africano', 1),
(21, 8, 'Hipopótamo', 0),
(22, 8, 'Girafa', 0),
(25, 13, 'Petronas Twin Towers, Malaysia', 1),
(26, 13, 'Zifeng Tower, China', 0),
(27, 13, 'Trump Intl. Hotel & Tower, United States', 0),
(28, 13, 'Al Hamra Tower, Kuwait', 0),
(29, 14, 'Kip', 1),
(30, 14, 'Ruble', 0),
(31, 14, 'Konra', 0),
(32, 14, 'Dollar', 0),
(33, 15, '1976', 1),
(34, 15, '1978', 0),
(35, 15, '1980', 0),
(36, 15, '1974', 0),
(37, 16, 'Saffron', 1),
(38, 16, 'Cinnamon', 0),
(39, 16, 'Cardamom', 0),
(40, 16, 'Vanilla', 0),
(41, 17, 'Three', 1),
(42, 17, 'Four', 0),
(43, 17, 'Five', 0),
(44, 17, 'Six', 0),
(45, 9, 'Madonna', 1),
(46, 9, 'Lady Gaga', 0),
(47, 9, 'Britney Spears', 0),
(48, 18, 'Adele', 0),
(49, 18, 'Beyoncé', 1),
(50, 18, 'Taylor Swift', 0),
(51, 19, 'Miley Cyrus', 0),
(52, 19, 'Selena Gomez', 0),
(53, 19, 'Ariana Grande', 1),
(54, 20, 'Teenage Dream', 1),
(55, 20, 'Prism', 0),
(56, 20, 'One of the Boys', 0),
(57, 21, 'Rihanna', 0),
(58, 21, 'Taylor Swift', 1),
(59, 21, 'Dua Lipa', 0),
(60, 22, 'Paris, França', 0),
(61, 22, 'Atenas, Grécia', 1),
(62, 22, 'Roma, Itália', 0),
(63, 23, 'Os cinco continentes habitados do mundo', 1),
(64, 23, 'Os cinco primeiros esportes criados', 0),
(65, 23, 'Os cinco deuses gregos do Olimpo', 0),
(66, 24, 'Usain Bolt', 0),
(67, 24, 'Michael Phelps', 1),
(68, 24, ' Simone Biles', 0),
(69, 25, 'Rio 2016', 0),
(70, 25, 'Londres 2012', 0),
(71, 25, 'Tóquio 2020', 1),
(72, 26, 'Atari 2600', 0),
(73, 26, 'Magnavox Odyssey', 1),
(74, 26, 'Nintendo', 0),
(76, 27, 'PlayStation 2', 1),
(77, 27, 'Nintendo Wii', 0),
(78, 27, 'Xbox 360', 0),
(79, 28, 'Azeroth', 0),
(80, 28, 'Mushroom Kingdom', 0),
(81, 28, 'Hyrule', 1),
(82, 29, 'Pokémon', 0),
(83, 29, 'Mario', 1),
(84, 29, 'Grand Theft Auto (GTA)', 0),
(85, 30, 'Oceano Atlântico', 0),
(86, 30, 'Oceano Índico', 0),
(87, 30, 'Oceano Pacífico', 1),
(88, 31, 'Prata', 0),
(89, 31, 'Ouro', 1),
(90, 31, 'Cobre', 0),
(91, 32, 'China', 0),
(92, 32, 'Estados Unidos', 0),
(93, 32, 'Índia', 1),
(94, 33, 'A invasão da Polônia pela Alemanha.', 0),
(96, 33, 'O bombardeio de Pearl Harbor.', 0),
(98, 33, 'O assassinato do Arquiduque Francisco Ferdinando', 1),
(99, 34, 'França e Inglaterra', 1),
(100, 34, 'Grécia e Pérsia', 0),
(101, 34, 'Alemanha e União Soviética', 0),
(102, 35, 'O lançamento da bomba atômica em Hiroshima.', 0),
(103, 35, 'A rendição oficial da Alemanha Nazista.', 0),
(104, 35, 'O desembarque aliado nas praias da Normandia', 1),
(105, 36, 'Guerra Fria', 1),
(106, 36, 'Guerra de Trincheiras', 0),
(107, 36, 'Grande Guerra', 0),
(108, 37, 'Nederlands', 1),
(109, 37, 'Dansk', 0),
(110, 37, 'Deutsch', 0),
(111, 37, 'Hollander', 0),
(112, 38, 'Niagara Mohawk Building', 1),
(113, 38, 'Taipei 101', 0),
(114, 38, 'One Detroit Center', 0),
(115, 38, 'Westendstrasse 1', 0),
(116, 39, '282 feet', 1),
(117, 39, '79 feet', 0),
(118, 39, '1,640 feet', 0),
(119, 39, '12,092 feet', 0),
(120, 40, 'Omega', 1),
(121, 40, 'Mu', 0),
(122, 40, 'Epsilon', 0),
(123, 40, 'Kappa', 0),
(124, 41, 'Economics', 1),
(125, 41, 'Philosophy', 0),
(126, 41, 'Politics', 0),
(127, 41, 'Physics', 0),
(128, 42, 'Reposta 1', 1),
(129, 42, 'Resposta 2', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `icone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `temas`
--

INSERT INTO `temas` (`id`, `nome`, `icone`) VALUES
(0, 'Sistema - Desafio Diário', NULL),
(1, 'Conhecimentos Gerais', '🧠'),
(2, 'Tecnologia', '💻'),
(3, 'Inglês', 'EN'),
(5, 'Animais', '🦁'),
(6, 'DIVAS POP', '💃'),
(7, 'Olimpíadas', '🏅'),
(8, 'VIDEO GAME', '🎮'),
(9, 'Guerras e Conflitos Históricos', '⚔️'),
(10, 'Novo tema', '💡');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_cadastro`) VALUES
(1, 'Belle', 'imaciel892@gmail.com', '$2y$10$DaHIbrHxZdh9A0gJR6GZf.14Tdn97EU/fBTpsk1BsoQyABw1CdUDS', '2026-03-10 17:10:40');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices para tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delete temas` (`tema_id`);

--
-- Índices para tabela `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ranking_diario`
--
ALTER TABLE `ranking_diario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pergunta_id` (`pergunta_id`);

--
-- Índices para tabela `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `ranking_diario`
--
ALTER TABLE `ranking_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de tabela `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD CONSTRAINT `delete temas` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `perguntas_ibfk_1` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`);

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
