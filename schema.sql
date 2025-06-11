
DROP DATABASE IF EXISTS financial_db;
CREATE DATABASE financial_db DEFAULT CHARACTER SET utf8mb4;
USE financial_db;

CREATE TABLE users (
    user_id VARCHAR(50) PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(200) NOT NULL
);

CREATE TABLE financial_records (
    record_id VARCHAR(50) PRIMARY KEY,
    amount FLOAT NOT NULL,
    date DATE NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    user_id VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE savings_plans (
    plan_id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    target_amount FLOAT NOT NULL,
    current_amount FLOAT DEFAULT 0.0,
    start_date DATE NOT NULL,
    target_date DATE NOT NULL,
    user_id VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
