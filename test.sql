-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2014 at 06:09 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=``@`localhost` FUNCTION `amdetail`(acc int(11)) RETURNS int(11)
    READS SQL DATA
begin declare ammt int; declare exit handler for not found return null; select amount into ammt from transac where accno=acc;  return ammt; end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `accno` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `balance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accno`, `startdate`, `balance`) VALUES
(123, '2014-01-01', 10000),
(345, '2014-02-01', 19000);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` date NOT NULL,
  `totalcost` double NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `serial_no` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(11) NOT NULL,
  `product_type` varchar(256) NOT NULL,
  `product_name` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`serial_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`serial_no`, `product_id`, `product_type`, `product_name`, `price`) VALUES
(1, 'S01', 'SHAMPOO', 'PANTENE', 120),
(2, 'S02', 'SHAMPOO', 'H&S', 100),
(3, 'S03', 'SHAMPOO', 'CLINIC', 110),
(4, 'S04', 'SHAMPOO', 'HIM', 130),
(5, 'S05', 'SHAMPOO', 'XINIX', 160),
(6, 'P01', 'SOAP', 'LUX', 40),
(7, 'P02', 'SOAP', 'DETTOL', 50),
(8, 'P03', 'SOAP', 'LIFEBUOY', 30),
(9, 'P04', 'SOAP', 'CINTHOL', 35),
(10, 'P05', 'SOAP', 'DOVE', 80),
(11, 'B01', 'BISCUIT', 'CLASSIC', 40),
(12, 'B02', 'BISCUIT', 'BOURBON', 30),
(13, 'B03', 'BISCUIT', 'PARLE', 40),
(14, 'B04', 'BISCUIT', 'MARIE', 45),
(15, 'B05', 'BISCUIT', 'GOODAY', 25),
(16, 'W01', 'WASHING POWDER', 'SURF', 25),
(17, 'W02', 'WASHING POWDER', 'RIN', 40),
(18, 'W03', 'WASHING POWDER', 'TIDE', 30),
(19, 'W04', 'WASHING POWDER', 'LXI', 40),
(20, 'W05', 'WASHING POWDER', 'NIRMA', 50),
(21, 'C01', 'CHOCOLATE', 'DAIRY MILK', 10),
(22, 'C02', 'CHOCOLATE', 'BARONE', 20),
(23, 'C03', 'CHOCOLATE', '5-STAR', 10),
(24, 'C04', 'CHOCOLATE', 'SNICKERS', 35),
(25, 'C05', 'CHOCOLATE', 'GEMS', 15);

-- --------------------------------------------------------

--
-- Table structure for table `transac`
--

CREATE TABLE IF NOT EXISTS `transac` (
  `accno` int(11) NOT NULL,
  `dateodtran` date NOT NULL,
  `mode` enum('deposit','withdraw') DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transac`
--

INSERT INTO `transac` (`accno`, `dateodtran`, `mode`, `amount`) VALUES
(123, '2014-01-01', 'deposit', 10000),
(345, '2014-01-01', 'deposit', 20000),
(345, '2014-01-02', 'withdraw', 2000),
(345, '2014-01-01', 'deposit', 1000);

--
-- Triggers `transac`
--
DROP TRIGGER IF EXISTS `updatetransac`;
DELIMITER //
CREATE TRIGGER `updatetransac` AFTER INSERT ON `transac`
 FOR EACH ROW begin case 
when new.mode='withdraw' then update account set account.balance=account.balance-new.amount where account.accno=new.accno;
when new.mode='deposit' then update account set account.balance=account.balance+new.amount where account.accno=new.accno;
end case;
end
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
