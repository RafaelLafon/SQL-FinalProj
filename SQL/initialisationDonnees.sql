CREATE TABLE IF NOT EXISTS restaurants (
    RestaurantId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name VARCHAR(50),
    Location VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS commands (
    CommandId INTEGER PRIMARY KEY AUTOINCREMENT,
    RestaurantId INT,
    CommandDate DATETIME,
    Commentary TEXT,
    DeliveryPlace VARCHAR(255),
    DeliveryStatus TEXT,
    ReasonForFailure TEXT,
    FOREIGN KEY (RestaurantId) REFERENCES restaurants(RestaurantId)
);


INSERT INTO restaurants (Name, Location) VALUES ('Resto1', 'Nimes');
INSERT INTO restaurants (Name, Location) VALUES ('Resto2', 'Toulouse');