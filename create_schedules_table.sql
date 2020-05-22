DROP TABLE IF EXISTS schedules;
CREATE TABLE  API.schedules (
    id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id INT(11) NOT NULL,
    plan1 VARCHAR(30),
    plan2 VARCHAR(30),
    plan3 VARCHAR(30),
    plan4 VARCHAR(30),
    plan5 VARCHAR(30),
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);