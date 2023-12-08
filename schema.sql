CREATE DATABASE IF NOT EXISTS dolphin_crm DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE dolphin_crm;

CREATE TABLE IF NOT EXISTS users
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    firstname  VARCHAR(255)  NOT NULL,
    lastname   VARCHAR(255)  NOT NULL,
    email      VARCHAR(255)  NOT NULL,
    password   VARCHAR(4096) NOT NULL,
    role       VARCHAR(255)  NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    title       VARCHAR(255) NOT NULL,
    firstname   VARCHAR(255) NOT NULL,
    lastname    VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    telephone   VARCHAR(255) NOT NULL,
    company     VARCHAR(255) NOT NULL,
    type        ENUM ('Sales Lead', 'Support'),

    assigned_to INT          NOT NULL,
    created_by  INT          NOT NULL,
    FOREIGN KEY (assigned_to) REFERENCES users (id),
    FOREIGN KEY (created_by) REFERENCES users (id),

    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS notes
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    content    TEXT NOT NULL,

    contact_id INT  NOT NULL,
    created_by INT  NOT NULL,
    FOREIGN KEY (contact_id) REFERENCES contacts (id),
    FOREIGN KEY (created_by) REFERENCES users (id),

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);