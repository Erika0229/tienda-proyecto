CREATE TABLE IF NOT EXISTS pagos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    codigo_postal VARCHAR(20) NOT NULL,
    nombre_tarjeta VARCHAR(255) NOT NULL,
    numero_tarjeta VARCHAR(20) NOT NULL,
    mes_vencimiento VARCHAR(20) NOT NULL,
    anio_vencimiento YEAR NOT NULL,
    cvv VARCHAR(4) NOT NULL
);

CREATE TABLE `direcciones` (
  id bigint(20) UNSIGNED NOT NULL,
  nombre_completo varchar(255) NOT NULL,
  correo varchar(255) NOT NULL,
  direccion varchar(255) NOT NULL,
  ciudad varchar(100) NOT NULL,
  codigo_postal varchar(20) NOT NULL
);
