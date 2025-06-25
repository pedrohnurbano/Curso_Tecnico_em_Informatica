-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 09/06/2025 às 19h38min
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `livraria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `autor`
--

INSERT INTO `autor` (`codigo`, `nome`, `pais`) VALUES
(1, 'Miguel de Cervantes', 'Espanha'),
(2, 'Gabriel GarcÃ­a MÃ¡rquez', 'ColÃ´mbia'),
(3, 'Jane Austen', 'Inglaterra (Reino Unido)'),
(4, 'Dante Alighieri', 'ItÃ¡lia'),
(5, 'William Shakespeare', 'Inglaterra (Reino Unido)'),
(6, 'Leon TolstÃ³i', 'RÃºssia'),
(7, 'Gustave Flaubert', 'FranÃ§a'),
(8, 'Marcel Proust', 'FranÃ§a'),
(9, 'James Joyce', 'Irlanda'),
(10, 'Herman Melville', 'Estados Unidos'),
(11, 'FiÃ³dor DostoiÃ©vski', 'RÃºssia'),
(12, 'F. Scott Fitzgerald', 'Estados Unidos'),
(13, 'George Orwell', 'Ãndia BritÃ¢nica'),
(14, 'Homero', 'GrÃ©cia'),
(15, 'Mary Shelley', 'Inglaterra (Reino Unido)'),
(16, 'Victor Hugo', 'FranÃ§a'),
(17, 'Antoine de Saint-ExupÃ©ry', 'FranÃ§a'),
(18, 'Machado de Assis', 'Brasil'),
(19, 'Leon TolstÃ³i', 'RÃºssia'),
(20, 'J.R.R. Tolkien', 'Ãfrica do Sul');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`) VALUES
(1, 'Romance'),
(2, 'FicÃ§Ã£o CientÃ­fica'),
(3, 'Fantasia'),
(4, 'MistÃ©rio'),
(5, 'Thriller/Suspense'),
(6, 'Terror/Horror'),
(7, 'FicÃ§Ã£o HistÃ³rica'),
(8, 'FicÃ§Ã£o ContemporÃ¢nea'),
(9, 'Realismo MÃ¡gico'),
(10, 'Literatura Infantojuvenil'),
(11, 'Poesia'),
(12, 'Drama/PeÃ§a Teatral'),
(13, 'ComÃ©dia'),
(14, 'TragÃ©dia'),
(15, 'SÃ¡tira'),
(16, 'FÃ¡bula'),
(17, 'Biografia/Autobiografia'),
(18, 'Ensaio'),
(19, 'CrÃ´nica'),
(20, 'FicÃ§Ã£o de Aventura');

-- --------------------------------------------------------

--
-- Estrutura da tabela `editora`
--

CREATE TABLE IF NOT EXISTS `editora` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `editora`
--

INSERT INTO `editora` (`codigo`, `nome`) VALUES
(1, 'IntrÃ­nseca'),
(2, 'Sextante'),
(3, 'Rocco'),
(4, 'HarperCollins'),
(5, 'DarkSide Books'),
(6, 'AntofÃ¡gica'),
(7, 'Companhia Penguin'),
(8, 'Zahar'),
(9, 'Arqueiro'),
(10, 'Citadel'),
(11, 'Fato Editorial'),
(12, 'Pipoca e Nanquim'),
(13, 'Buzz Editora'),
(14, 'Objetiva'),
(15, 'Wish'),
(16, 'Editorial Record'),
(17, 'Cosac Naify'),
(18, 'Companhia das Letras'),
(19, 'Editora 34'),
(20, 'PrincÃ­pia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE IF NOT EXISTS `livro` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `isbn` int(20) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `numero_paginas` int(4) NOT NULL,
  `ano` int(4) NOT NULL,
  `cod_autor` int(5) NOT NULL,
  `cod_categoria` int(5) NOT NULL,
  `cod_editora` int(5) NOT NULL,
  `sinopse` text NOT NULL,
  `preco` float(6,2) NOT NULL,
  `foto_capa` varchar(100) NOT NULL,
  `foto_contracapa` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `cod_autor` (`cod_autor`),
  KEY `cod_categoria` (`cod_categoria`),
  KEY `cod_editora` (`cod_editora`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`codigo`, `isbn`, `titulo`, `numero_paginas`, `ano`, `cod_autor`, `cod_categoria`, `cod_editora`, `sinopse`, `preco`, `foto_capa`, `foto_contracapa`) VALUES
(14, 97885, 'A Metamorfose', 144, 2029, 1, 1, 1, '"A Metamorfose", de Franz Kafka, conta a histÃ³ria de Gregor Samsa, um caixeiro-viajante que acorda transformado em um inseto monstruoso. A narrativa explora as dificuldades de Gregor em lidar com sua nova condiÃ§Ã£o, as reaÃ§Ãµes de sua famÃ­lia e os temas da alienaÃ§Ã£o e da alienaÃ§Ã£o social.', 58.90, '1e74415b1687d9dc44cf8ba8c49b54da.jpg', '761d14aa4ea68a62cf9a2e641067805d.jpg'),
(15, 97817, 'A Psicologia Financeira', 304, 2021, 2, 2, 2, '"A Psicologia Financeira" de Morgan Housel explora como as emoÃ§Ãµes, comportamentos e experiÃªncias pessoais influenciam as decisÃµes financeiras, desafiando a visÃ£o tradicional de finanÃ§as, que foca em nÃºmeros e estratÃ©gias tÃ©cnicas.', 35.90, 'ce2132ac517ff433fb3ee9d110db01ec.jpg', '584b6e4754bc179a666126250b9374bc.jpg'),
(16, 85950, 'O Homem Mais Rico da BabilÃ´nia', 160, 2017, 3, 3, 3, 'As parÃ¡bolas sÃ£o ambientadas na antiga BabilÃ´nia e trazem ensinamentos sobre assuntos financeiros: Planejamento financeiro, a importÃ¢ncia de se poupar, emprÃ©stimos, entre outros. SÃ£o contadas por um personagem babilÃ´nico fictÃ­cio chamado Arkad, um escriba pobre que se tornou o "homem mais rico da BabilÃ´nia".', 24.99, '06eb8c7ec987107463d8f36b0df7595d.jpg', 'b6d1ca1eca09624eb944422e57f959f6.jpg'),
(17, 97808, 'HÃ¡bitos AtÃ´micos', 320, 2019, 4, 4, 4, '"HÃ¡bitos AtÃ´micos", de James Clear, Ã© um guia prÃ¡tico que revela como criar bons hÃ¡bitos e abandonar os maus. O livro enfatiza a importÃ¢ncia das pequenas mudanÃ§as diÃ¡rias, comparando-as a "Ã¡tomos" que, quando acumulados, levam a resultados impressionantes.', 55.84, '5d4df3ded24b38fbb7a5a8f7256ed7db.jpg', '318ee51a6437dd848ecacdd87ceab72a.jpg'),
(18, 97816, 'As 48 Leis do Poder', 544, 2021, 5, 5, 5, 'Em As 48 leis do poder, o leitor aprende a manipular pessoas e situaÃ§Ãµes para alcanÃ§ar seus objetivos. E descobre por que alguns conseguem ser tÃ£o bem-sucedidos, enquanto outros estÃ£o sempre sendo passados para trÃ¡s. Querer ser melhor do que o chefe, por exemplo, Ã© um erro fatal.', 75.90, '83c2115568b304ebaae59e549048e946.jpg', '2bd3672832fd9b0e60bb13921b79921c.jpg'),
(19, 97811, 'A Hora da Estrela', 88, 2020, 6, 6, 6, 'MacabÃ©a Ã© uma jovem nordestina que vive em SÃ£o Paulo. Ela trabalha como datilÃ³grafa em uma pequena firma e vive em uma pensÃ£o miserÃ¡vel, onde divide o quarto com outras trÃªs mulheres. MacabÃ©a nÃ£o tem ambiÃ§Ãµes, mas gostaria de ter um namorado. Um dia, ela conhece o metalÃºrgico OlÃ­mpico e os dois comeÃ§am a namorar.', 33.85, '44e22faae2c4f1d2869ea238da2db519.jpg', 'c5a494fde30a92903618fe5da193e56e.jpg'),
(20, 97868, 'Como Fazer Amigos e Influenciar Pessoas', 256, 2019, 7, 7, 7, '"Como fazer amigos e influenciar pessoas" Ã© um clÃ¡ssico escrito por Dale Carnegie, que oferece um guia prÃ¡tico sobre como estabelecer relacionamentos sÃ³lidos e influenciar positivamente as pessoas ao nosso redor.', 59.90, '5f652eaeea889cfea4e17c29182c6c1d.jpg', 'af7c0f0b3d89b894dce679a601b41acf.jpg'),
(21, 97833, 'Tudo Ã© Rio', 210, 2021, 8, 8, 8, '"Tudo Ã© rio", de Carla Madeira, conta a histÃ³ria de Dalva e VenÃ¢ncio, um casal que tem a vida transformada apÃ³s uma perda trÃ¡gica, resultado do ciÃºme doentio do marido. A entrada de Lucy, a prostituta mais cobiÃ§ada da cidade, na vida deles gera um triÃ¢ngulo amoroso e intensifica a trama.', 49.60, '5ec1d0f01558b5f076047d039ae40ca7.jpg', '4460171204f85524a078fa197df177b5.jpg'),
(22, 97820, 'A Biblioteca da Meia-Noite', 308, 2021, 9, 9, 9, '"A Biblioteca da Meia-Noite" de Matt Haig conta a histÃ³ria de Nora Seed, uma mulher de 35 anos infeliz que, apÃ³s uma sÃ©rie de eventos desastrosos, Ã© levada a uma biblioteca entre a vida e a morte.', 47.92, '63f68d1964695a2e728d54c25221a11d.jpg', '4aa2f98696b4b213b8fbff061d7d3ac7.jpg'),
(23, 97844, 'Mais Esperto que o Diabo', 208, 2014, 10, 10, 10, 'O livro ensina a superar medos e limitaÃ§Ãµes e aproveitar a adversidade para descobrir um benefÃ­cio equivalente. Entrevistando o Diabo, o autor identifica os maiores obstÃ¡culos para o desenvolvimento humano: medo, procrastinaÃ§Ã£o, raiva, ciÃºmes, que sÃ£o tidos como ferramentas do diabo para a alienaÃ§Ã£o humana.', 59.90, 'd37c0b0f70eab411d2041a33727da8e9.jpg', '09683ae856a382843bae51bf5c69123d.jpg'),
(24, 97815, 'Nada Pode me Ferir', 320, 2023, 11, 11, 11, '"Nada Pode Me Ferir" (de David Goggins) Ã© uma histÃ³ria de superaÃ§Ã£o que documenta a jornada de Goggins, desde uma infÃ¢ncia difÃ­cil marcada por pobreza, racismo e maus-tratos, atÃ© se tornar um dos maiores atletas de resistÃªncia do mundo, um ex-militar que completou os treinamentos das forÃ§as de elite (Navy SEAL, Army Ranger e TACP).', 59.90, '4b6295f8024746a05d0862bd663682d1.jpg', '2e2d8ede08cc21efc89fdbbdb9350120webp'),
(25, 97829, 'As Coisas que VocÃª sÃ³ vÃª Quando Desacelera', 256, 2017, 12, 12, 12, 'As coisas que vocÃª sÃ³ vÃª quando desacelera Ã© um convite para enxergar o valor de pausas, presenÃ§a e aceitaÃ§Ã£o em uma sociedade acelerada. Haemin Sunim nos lembra que a felicidade nÃ£o Ã© encontrada em conquistas externas, mas no cultivo de uma mente serena e consciente, em harmonia com o momento presente.', 55.90, '65d1d27f0ab3066540afffaa01a913a0.jpg', 'eea34efe41396f50e0339aad4e9657f6webp'),
(26, 97841, 'A Coragem de Ser Imperfeito', 208, 2016, 13, 13, 13, 'BrenÃ© Brown, que durante 12 anos desenvolveu uma pesquisa pioneira sobre vulnerabilidade, essa condiÃ§Ã£o nÃ£o Ã© uma medida de fraqueza, mas a melhor definiÃ§Ã£o de coragem. Quando fugimos de emoÃ§Ãµes como medo, mÃ¡goa e decepÃ§Ã£o, tambÃ©m nos fechamos para o amor, a aceitaÃ§Ã£o, a empatia e a criatividade.', 49.90, '7aca4256e9a2b4a56b06c0d56666de65.jpg', 'ed4467a37bfe80365384abab0774cbff.jpg'),
(27, 97863, 'A Gente Mira no Amor e Acerta na SolidÃ£o', 160, 2022, 14, 14, 14, '"A gente mira no amor e acerta na solidÃ£o" Ã© um livro da psicanalista Ana Suy que explora as nuances das relaÃ§Ãµes amorosas e a experiÃªncia da solidÃ£o, abordando-as nÃ£o como opostos, mas como parte intrÃ­nseca do ciclo da vida. A obra busca entender como os indivÃ­duos se relacionam com seus sentimentos, questionando como as relaÃ§Ãµes amorosas e a solidÃ£o se interligam.', 55.90, 'a69d435bb1704ed9d3ef54faefcda143.jpg', 'b7b91a4a3af7498dd3c9fcd21ebf194e.jpg'),
(28, 97803, 'AdmirÃ¡vel Mundo Novo', 312, 2014, 15, 15, 15, '"AdmirÃ¡vel Mundo Novo", de Aldous Huxley, Ã© uma distopia que retrata uma sociedade futura onde a ciÃªncia e a tecnologia sÃ£o usadas para criar um mundo aparentemente perfeito, mas que na verdade Ã© totalitÃ¡rio e alienante. Os seres humanos sÃ£o geneticamente manipulados e condicionados desde a concepÃ§Ã£o para pertencer a diferentes castas, e a felicidade Ã© garantida atravÃ©s do uso de drogas e entretenimento.', 42.91, 'b7821fbd12fa71a8f5c0b06d2e3f7c35.jpg', '1ddf57f5f012a13e675634dac8d4eb64.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(55) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(10) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `nome`, `email`, `senha`) VALUES
(3, 'Pedro Henrique do Nascimento Urbano', 'pedro@gmail.com', '123456'),
(4, 'Cristiane Pavei Martinello Fernandes', 'cris@gmail.com', '123456');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `livro_ibfk_1` FOREIGN KEY (`cod_autor`) REFERENCES `autor` (`codigo`),
  ADD CONSTRAINT `livro_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `categoria` (`codigo`),
  ADD CONSTRAINT `livro_ibfk_3` FOREIGN KEY (`cod_editora`) REFERENCES `editora` (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
