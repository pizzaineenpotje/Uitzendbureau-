USE Uitzendbureau;

CREATE TABLE candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender ENUM('M', 'V', 'X') NOT NULL,
    bsn VARCHAR(9) NOT NULL UNIQUE,
    birth_date DATE,
    desired_salary DECIMAL(10,2),
    skills VARCHAR(255),
    education_and_courses VARCHAR(255)
);

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

