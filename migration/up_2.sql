CREATE TABLE role(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  role varchar(255) COLLATE 'utf8_general_ci' NOT NULL
);
INSERT INTO role (id, role) VALUES (NULL, 'Админ');
INSERT INTO role (id, role) VALUES (NULL, 'Пользователь');
UPDATE users SET role=(SELECT id FROM role WHERE role='Админ');
