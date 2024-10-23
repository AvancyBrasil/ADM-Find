CREATE DATABASE  db_usuarios
 Use db_usuarios;

 
CREATE TABLE tbl_usuarios (
    login VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL
)
 
INSERT INTO tbl_usuarios (login,senha) VALUES
('admin', 'admin123')

SELECT * FROM tbl_usuarios
 