CREATE TABLE productos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

CREATE TABLE carrito (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(255),
    correo VARCHAR(255),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    codigo_postal VARCHAR(20),
    producto_id INT,
    total DECIMAL(10, 2),
    metodo_pago VARCHAR(50),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

