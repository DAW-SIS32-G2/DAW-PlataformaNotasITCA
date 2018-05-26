drop user if exists 'usuarioItca'@'localhost';
create user 'usuarioItca'@'localhost' identified by '12345';
grant all privileges on *.* to 'usuarioItca'@'localhost';
FLUSH PRIVILEGES;
drop database if exists SistemaNotasItca;
create database SistemaNotasItca;