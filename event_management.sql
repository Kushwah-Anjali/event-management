CREATE DATABASE IF NOT EXISTS event_db;
USE event_db;

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  description TEXT,
  date DATE
);

INSERT INTO events(title,description,date) VALUES
('Hackathon','48-hour coding event','2025-08-10'),
('Meetup','Local community meet','2025-09-05');

CREATE TABLE registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  event_id INT,
  registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES events(id)
);
