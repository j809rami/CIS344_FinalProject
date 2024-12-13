/*
CIS 344 - Final Project - Jose Ramirez 
MySQL Implementation - Database setup 
Table, Relationship, Stored Procedure and Function setup
*/

-- creating database
CREATE DATABASE resturant_reservations;

-- using created database
USE resturant_reservations;

-- creating the 'customers' table
CREATE TABLE customers(
    customerId INT NOT NULL UNIQUE AUTO_INCREMENT,
    customerName VARCHAR(45) NOT NULL,
    contactInfo VARCHAR(200),
    PRIMARY KEY (customerId)
);

-- creating the 'reservations' table
CREATE TABLE reservations(
    reservationId INT NOT NULL UNIQUE AUTO_INCREMENT,
    customerId INT NOT NULL,
    reservationTime DATETIME NOT NULL,
    numberOfGuests INT NOT NULL,
    specialRequests VARCHAR(200),
    PRIMARY KEY (reservationId),
    FOREIGN KEY (customerId) REFERENCES customers(customerId) -- how does foreign key establishment work?
);

-- creating the 'dining preferences' table
CREATE TABLE DiningPreferences(
    preferenceID INT NOT NULL UNIQUE AUTO_INCREMENT,
    customerId INT NOT NULL,
    favoriteTable VARCHAR(45),
    dietaryRestrictions VARCHAR(200),
    PRIMARY KEY (preferenceId),
    FOREIGN KEY (customerId) REFERENCES customers(customerId)
);

-- creating the stored procedure 'findReservations'
DELIMITER // -- statement terminator
CREATE PROCEDURE findReservations(IN custId INT)
BEGIN
    SELECT * FROM reservations WHERE customerId = custId;
END;
//

DELIMITER;  -- reset delimiter to original (semicolon)

-- creating the stored procedure 'addSpecialRequest'
DELIMITER //
CREATE PROCEDURE addSpecialRequest(IN resId, IN requests VARCHAR(200))
BEGIN
    UPDATE Reservations SET specialRequests = requests WHERE reservationId = resId;
END;
//

DELIMITER;

-- create the addReservation stored procedure
DELIMITER //
CREATE PROCEDURE addReservation(
    IN custName VARCHAR(45),
    IN contact VARCHAR(200),
    IN resTime DATETIME,
    IN guests INT,
    IN requests VARCHAR(200)
)
BEGIN
    DECLARE custId INT;
    -- checking if the customer exists
    SELECT customerId, INTO custId FROM customers where customerName = custName AND contactInfo = contact;
    -- if the customer does not exist, create a new customer
    IF custId IS NULL THEN 
        INSERT INTO customers (customerName, contactInfo) VALUES (custName, contact);
        SET custId = LAST_INSERT_ID();
    END IF; 

    -- add reservation
    INSERT INTO reservations (customerId, reservationTime, numberOfGuests, specialRequests)
    VALUES(custId, resTime, guests, requests);

END;
//
DELIMITER ; 

-- inserting data into the created database and their tables
INSERT INTO customers(customerName, contactInfo)
VALUES
('Mark Henry', 'mhenry@gmail.com'),
('Jeff Johnson', 'jjohnson@gmail.com'),
('Mitchell Torres', 'mtorres@gmail.com');

-- Insert sample data into Reservations table
INSERT INTO reservations(customerId, reservationTime, numberOfGuests, specialRequests)
VALUES
(1, '2024-12-01 19:00:00', 4, 'Vegan options please'),
(2, '2024-12-02 20:00:00', 2, 'Booth seat please'),
(3, '2024-12-03 21:00:00', 3, 'Anniversary celebration');

-- Insert sample data into DiningPreferences table
INSERT INTO DiningPreferences(customerId, favoriteTable, dietaryRestrictions)
VALUES
(1, 'Corner Table', 'No meat or dairy'),
(2, 'No Favorite Table', 'Gluten-free'),
(3, 'Private Room', 'Vegan');
