CREATE TABLE IF NOT EXISTS restaurants (
    RestaurantId INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50),
    Location VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS commands (
    CommandId INT PRIMARY KEY AUTO_INCREMENT,
    RestaurantId INT,
    CommandDate DATETIME,
    Commentary TEXT,
    DeliveryPlace VARCHAR(255),
    DeliveryStatus ENUM('Faite', 'Échoué'),
    ReasonForFailure TEXT,
    FOREIGN KEY (RestaurantId) REFERENCES restaurants(RestaurantId)
);
