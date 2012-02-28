-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Fev 17, 2010 as 12:32 AM
-- Versão do Servidor: 5.0.67
-- Versão do PHP: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `phpms`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `alias` varchar(45) NOT NULL COMMENT 'Um apelido único para o evento\n',
  `description` mediumtext,
  `parent_id` int(11) default NULL COMMENT 'Usado para indicar se o evento pertence a outro maior já cadastrado',
  `free` tinyint(1) NOT NULL default '1',
  `subscription_count` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event_dates`
--

DROP TABLE IF EXISTS `event_dates`;
CREATE TABLE IF NOT EXISTS `event_dates` (
  `id` int(11) NOT NULL auto_increment,
  `event_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event_prices`
--

DROP TABLE IF EXISTS `event_prices`;
CREATE TABLE IF NOT EXISTS `event_prices` (
  `id` int(11) NOT NULL auto_increment,
  `event_id` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `start_date` date NOT NULL,
  `final_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL auto_increment,
  `subscription_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `information` varchar(255) default NULL,
  `confirmed` tinyint(1) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(45) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `token` varchar(40) default NULL,
  `token_expires_at` date default NULL,
  `last_access` datetime default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `type` varchar(30) NOT NULL default 'participant',
  `active` tinyint(1) NOT NULL default '0',
  `account_validation_token` varchar(40) default NULL,
  `account_validation_expires_at` datetime default NULL,
  `cpf` varchar(14) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(2) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

