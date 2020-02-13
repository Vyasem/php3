CREATE TABLE role(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  role varchar(255) COLLATE 'utf8_general_ci' NOT NULL
);
INSERT INTO users (id, name) VALUES (NULL, 'Админ');
INSERT INTO users (id, name) VALUES (NULL, 'Пользователь');
UPDATE users SET role=(SELECT id FROM role WHERE role='Админ');
