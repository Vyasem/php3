CREATE TABLE users(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name varchar(255) COLLATE 'utf8_general_ci' NOT NULL,
  role varchar(255) COLLATE 'utf8_general_ci' NOT NULL DEFAULT ""
);
INSERT INTO users (id,name) VALUES (NULL, 'admin');

