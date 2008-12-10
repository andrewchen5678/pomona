-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2008 at 09:46 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: pomonatransit
--

-- --------------------------------------------------------

--
-- Table structure for table ActualTripStopInfo
--



--
-- Dumping data for table ActualTripStopInfo
--


-- --------------------------------------------------------

--
-- Table structure for table Bus
--

CREATE TABLE IF NOT EXISTS Bus (
  BusID int(11) NOT NULL auto_increment,
  Model varchar(50) NOT NULL,
  Year char(4) NOT NULL,
  PRIMARY KEY  (BusID)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED AUTO_INCREMENT=11 ;

--
-- Dumping data for table Bus
--

INSERT INTO Bus (BusID, Model, Year) VALUES
(1, 'toycar', '2001'),
(3, 'trash', '1999'),
(10, 'chafacar', '2004');

-- --------------------------------------------------------

--
-- Table structure for table Driver
--

CREATE TABLE IF NOT EXISTS Driver (
  DriverName varchar(50) NOT NULL,
  DriverTelephoneNumber char(10) NOT NULL,
  PRIMARY KEY  (DriverName)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Dumping data for table Driver
--

INSERT INTO Driver (DriverName, DriverTelephoneNumber) VALUES
('aaaa', '7653564567'),
('aaab', '1234567890'),
('abcd', '1234567890'),
('abcdefghi', '7653564567'),
('driver1', '7653564567'),
('driver2', '1234567890'),
('fdsfdstestgood', '7653564567'),
('javachafa', '6777666666');

-- --------------------------------------------------------

--
-- Table structure for table Stop
--

CREATE TABLE IF NOT EXISTS Stop (
  StopNumber int(11) NOT NULL auto_increment,
  StopAddress varchar(50) NOT NULL,
  PRIMARY KEY  (StopNumber)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED AUTO_INCREMENT=4 ;

--
-- Dumping data for table Stop
--

INSERT INTO Stop (StopNumber, StopAddress) VALUES
(1, 'stop1'),
(2, 'stop2'),
(3, 'stop3');

-- --------------------------------------------------------

--
-- Table structure for table Trip
--

CREATE TABLE IF NOT EXISTS Trip (
  TripNumber int(11) NOT NULL auto_increment,
  StartLocationName varchar(50) NOT NULL,
  DestinationName varchar(50) NOT NULL,
  PRIMARY KEY  (TripNumber)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED AUTO_INCREMENT=6 ;

--
-- Dumping data for table Trip
--

INSERT INTO Trip (TripNumber, StartLocationName, DestinationName) VALUES
(2, 'cla', 'village'),
(5, 'Building 8', 'Building 10');

-- --------------------------------------------------------

--
-- Table structure for table TripOffering
--

CREATE TABLE IF NOT EXISTS TripOffering (
  TripNumber int(11) NOT NULL,
  Date date NOT NULL,
  ScheduledStartTime time NOT NULL,
  ScheduledArrivalTime time NOT NULL,
  DriverName varchar(50) NOT NULL,
  BusID int(11) NOT NULL,
  PRIMARY KEY  (TripNumber,Date,ScheduledStartTime),
  KEY BusID (BusID),
  KEY DriverName (DriverName),
  KEY Date (Date),
  KEY ScheduledStartTime (ScheduledStartTime),
  KEY ScheduledArrivalTime (ScheduledArrivalTime)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Dumping data for table TripOffering
--

INSERT INTO TripOffering (TripNumber, Date, ScheduledStartTime, ScheduledArrivalTime, DriverName, BusID) VALUES
(2, '2008-12-08', '07:00:00', '09:00:00', 'driver1', 3);

-- --------------------------------------------------------

--
-- Table structure for table TripStopInfo
--

CREATE TABLE IF NOT EXISTS TripStopInfo (
  TripNumber int(11) NOT NULL,
  StopNumber int(11) NOT NULL,
  SequenceNumber int(11) NOT NULL,
  DrivingTime time NOT NULL,
  PRIMARY KEY  (TripNumber,StopNumber),
  KEY StopNumber (StopNumber)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Dumping data for table TripStopInfo
--

INSERT INTO TripStopInfo (TripNumber, StopNumber, SequenceNumber, DrivingTime) VALUES
(2, 3, 45678, '04:00:00'),
(5, 1, 12345, '02:00:00'),
(5, 2, 56789, '09:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table ActualTripStopInfo
--

CREATE TABLE IF NOT EXISTS ActualTripStopInfo (
  TripNumber int(11) NOT NULL,
  Date date NOT NULL,
  ScheduledStartTime time NOT NULL,
  StopNumber int(11) NOT NULL,
  ScheduledArrivalTime time NOT NULL,
  ActualStartTime time NOT NULL,
  ActualArrivalTime time NOT NULL,
  NumberOfPassengerIn int(11) NOT NULL,
  NumberOfPassengerOut int(11) NOT NULL,
  PRIMARY KEY  (TripNumber,Date,ScheduledStartTime,StopNumber),
  FOREIGN KEY (ScheduledArrivalTime) REFERENCES TripOffering (ScheduledArrivalTime) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (StopNumber) REFERENCES Stop (StopNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (TripNumber) REFERENCES TripOffering (TripNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (Date) REFERENCES TripOffering (Date) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (ScheduledStartTime) REFERENCES TripOffering (ScheduledStartTime) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;



--
-- Constraints for table TripOffering
--
ALTER TABLE TripOffering
  ADD CONSTRAINT TripOffering_ibfk_1 FOREIGN KEY (BusID) REFERENCES Bus (BusID) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT TripOffering_ibfk_2 FOREIGN KEY (TripNumber) REFERENCES Trip (TripNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT TripOffering_ibfk_3 FOREIGN KEY (DriverName) REFERENCES Driver (DriverName) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table TripStopInfo
--
ALTER TABLE TripStopInfo
  ADD CONSTRAINT tripstopinfo_ibfk_2 FOREIGN KEY (TripNumber) REFERENCES Trip (TripNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tripstopinfo_ibfk_1 FOREIGN KEY (StopNumber) REFERENCES Stop (StopNumber) ON DELETE CASCADE ON UPDATE CASCADE;
