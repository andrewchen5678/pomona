SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;



CREATE TABLE IF NOT EXISTS bus (
  BusID int(11) NOT NULL auto_increment,
  Model varchar(50) NOT NULL,
  BusYear char(4) NOT NULL,
  PRIMARY KEY  (BusID)
) ENGINE=InnoDB ROW_FORMAT=FIXED;



CREATE TABLE IF NOT EXISTS driver (
  DriverName varchar(50) NOT NULL,
  DriverTelephoneNumber char(10) NOT NULL,
  PRIMARY KEY  (DriverName)
) ENGINE=InnoDB ROW_FORMAT=FIXED;



CREATE TABLE IF NOT EXISTS stop (
  StopNumber int(11) NOT NULL auto_increment,
  StopAddress varchar(50) NOT NULL,
  PRIMARY KEY  (StopNumber)
) ENGINE=InnoDB  ROW_FORMAT=FIXED;



CREATE TABLE IF NOT EXISTS trip (
  TripNumber int(11) NOT NULL auto_increment,
  StartLocationName varchar(50) NOT NULL,
  DestinationName varchar(50) NOT NULL,
  PRIMARY KEY  (TripNumber)
) ENGINE=InnoDB  ROW_FORMAT=FIXED;



CREATE TABLE IF NOT EXISTS tripoffering (
  OfferID int(11) NOT NULL,
  TripNumber int(11) NOT NULL,
  OfferDate date NOT NULL,
  ScheduledStartTime time NOT NULL,
  ScheduledArrivalTime time NOT NULL,
  DriverName varchar(50) NOT NULL,
  BusID int(11) NOT NULL,
  PRIMARY KEY  (OfferID),
  FOREIGN KEY (BusID) REFERENCES bus (BusID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (TripNumber) REFERENCES trip (TripNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (DriverName) REFERENCES driver (DriverName) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE (TripNumber,OfferDate,ScheduledStartTime)
) ENGINE=InnoDB ROW_FORMAT=FIXED;


CREATE TABLE IF NOT EXISTS tripstopinfo (
  TripNumber int(11) NOT NULL,
  StopNumber int(11) NOT NULL,
  SequenceNumber int(11) NOT NULL,
  DrivingTime time NOT NULL,
  PRIMARY KEY  (TripNumber,StopNumber),
FOREIGN KEY (TripNumber) REFERENCES trip (TripNumber) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (StopNumber) REFERENCES stop (StopNumber) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=FIXED;


CREATE TABLE IF NOT EXISTS actualtripstopinfo (
  RecordID int(11) NOT NULL,
  OfferID int(11) NOT NULL,
  StopNumber int(11) NOT NULL,
  ActualStartTime time NOT NULL,
  ActualArrivalTime time NOT NULL,
  NumberOfPassengerIn int(11) NOT NULL,
  NumberOfPassengerOut int(11) NOT NULL,
  PRIMARY KEY  (RecordID),
  FOREIGN KEY (OfferID) REFERENCES tripoffering (OfferID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (StopNumber) REFERENCES tripstopinfo (StopNumber) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB ROW_FORMAT=FIXED;

INSERT INTO trip (TripNumber, StartLocationName, DestinationName) VALUES(1, 'cla', 'village');
INSERT INTO trip (TripNumber, StartLocationName, DestinationName) VALUES(2, 'building8', 'building9');
INSERT INTO trip (TripNumber, StartLocationName, DestinationName) VALUES(3, 'parking structure', 'village');
INSERT INTO trip (TripNumber, StartLocationName, DestinationName) VALUES(4, 'cla', 'building1');

INSERT INTO stop (StopNumber, StopAddress) VALUES(1, '1234 haha ave.');
INSERT INTO stop (StopNumber, StopAddress) VALUES(2, '5678 haha ave.');
INSERT INTO stop (StopNumber, StopAddress) VALUES(3, '4324 haha2 ave.');
INSERT INTO stop (StopNumber, StopAddress) VALUES(4, '2222 haha2 ave.');

INSERT INTO tripstopinfo (TripNumber, StopNumber, SequenceNumber, DrivingTime) VALUES(1, 2, 1233, '02:30:00');
INSERT INTO tripstopinfo (TripNumber, StopNumber, SequenceNumber, DrivingTime) VALUES(1, 3, 1234, '02:00:00');
INSERT INTO tripstopinfo (TripNumber, StopNumber, SequenceNumber, DrivingTime) VALUES(2, 3, 1222, '01:30:00');
INSERT INTO tripstopinfo (TripNumber, StopNumber, SequenceNumber, DrivingTime) VALUES(3, 1, 5678, '01:00:00');



