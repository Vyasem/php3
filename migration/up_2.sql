CREATE TABLE role(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  role varchar(255) COLLATE 'utf8_general_ci' NOT NULL,
  FOREIGN KEY (usersid) REFERENCES users (id),
);