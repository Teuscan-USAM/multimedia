-- ============================================================================
-- BASE DE DATOS: DIVISIÓN TERRITORIAL DE EL SALVADOR (COMPLETO)
-- Motor: MySQL 8+ (Charset UTF8MB4)
-- Incluye: 4 tablas + 1 País + 14 Departamentos + 44 Municipios + 262 Distritos
-- ============================================================================

-- ============================================================================
-- PARTE 1: CREACIÓN DE LAS 4 TABLAS
-- ============================================================================

CREATE TABLE IF NOT EXISTS ctl_pais (
    id_pais CHAR(2) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo_iso CHAR(2) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ctl_departamento (
    id_departamento INT PRIMARY KEY,
    id_pais CHAR(2) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    codigo VARCHAR(5) UNIQUE,
    FOREIGN KEY (id_pais) REFERENCES ctl_pais(id_pais)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ctl_municipio (
    id_municipio INT AUTO_INCREMENT PRIMARY KEY,
    id_departamento INT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    FOREIGN KEY (id_departamento) REFERENCES ctl_departamento(id_departamento),
    UNIQUE (id_departamento, nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ctl_distrito (
    id_distrito INT AUTO_INCREMENT PRIMARY KEY,
    id_municipio INT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    FOREIGN KEY (id_municipio) REFERENCES ctl_municipio(id_municipio),
    UNIQUE (id_municipio, nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================================
-- PARTE 2: INSERCIÓN DE PAÍS (1) Y DEPARTAMENTOS (14)
-- ============================================================================

INSERT IGNORE INTO ctl_pais (id_pais, nombre, codigo_iso)
VALUES ('SV', 'El Salvador', 'SV');

INSERT IGNORE INTO ctl_departamento (id_departamento, id_pais, nombre, codigo) VALUES
(1,  'SV', 'Ahuachapán',    '01'),
(2,  'SV', 'Santa Ana',     '02'),
(3,  'SV', 'Sonsonate',     '03'),
(4,  'SV', 'Chalatenango',  '04'),
(5,  'SV', 'La Libertad',   '05'),
(6,  'SV', 'San Salvador',  '06'),
(7,  'SV', 'Cuscatlán',     '07'),
(8,  'SV', 'La Paz',        '08'),
(9,  'SV', 'Cabañas',       '09'),
(10, 'SV', 'San Vicente',   '10'),
(11, 'SV', 'Usulután',      '11'),
(12, 'SV', 'San Miguel',    '12'),
(13, 'SV', 'Morazán',       '13'),
(14, 'SV', 'La Unión',      '14');


-- ============================================================================
-- PARTE 3: INSERCIÓN DE LOS 44 MUNICIPIOS
-- ============================================================================

INSERT IGNORE INTO ctl_municipio (id_departamento, nombre) VALUES
-- 01. Ahuachapán (3)
(1, 'Ahuachapán Norte'),
(1, 'Ahuachapán Centro'),
(1, 'Ahuachapán Sur'),

-- 02. Santa Ana (4)
(2, 'Santa Ana Norte'),
(2, 'Santa Ana Centro'),
(2, 'Santa Ana Este'),
(2, 'Santa Ana Oeste'),

-- 03. Sonsonate (4)
(3, 'Sonsonate Norte'),
(3, 'Sonsonate Centro'),
(3, 'Sonsonate Este'),
(3, 'Sonsonate Oeste'),

-- 04. Chalatenango (3)
(4, 'Chalatenango Norte'),
(4, 'Chalatenango Centro'),
(4, 'Chalatenango Sur'),

-- 05. La Libertad (6)
(5, 'La Libertad Norte'),
(5, 'La Libertad Centro'),
(5, 'La Libertad Oeste'),
(5, 'La Libertad Este'),
(5, 'La Libertad Costa'),
(5, 'La Libertad Sur'),

-- 06. San Salvador (5)
(6, 'San Salvador Norte'),
(6, 'San Salvador Oeste'),
(6, 'San Salvador Este'),
(6, 'San Salvador Centro'),
(6, 'San Salvador Sur'),

-- 07. Cuscatlán (2)
(7, 'Cuscatlán Norte'),
(7, 'Cuscatlán Sur'),

-- 08. La Paz (3)
(8, 'La Paz Oeste'),
(8, 'La Paz Centro'),
(8, 'La Paz Este'),

-- 09. Cabañas (2)
(9, 'Cabañas Este'),
(9, 'Cabañas Oeste'),

-- 10. San Vicente (2)
(10, 'San Vicente Norte'),
(10, 'San Vicente Sur'),

-- 11. Usulután (3)
(11, 'Usulután Norte'),
(11, 'Usulután Este'),
(11, 'Usulután Oeste'),

-- 12. San Miguel (3)
(12, 'San Miguel Norte'),
(12, 'San Miguel Centro'),
(12, 'San Miguel Oeste'),

-- 13. Morazán (2)
(13, 'Morazán Norte'),
(13, 'Morazán Sur'),

-- 14. La Unión (2)
(14, 'La Unión Norte'),
(14, 'La Unión Sur');


-- ============================================================================
-- PARTE 4: INSERCIÓN DE LOS 262 DISTRITOS
-- ============================================================================

-- ----------------------------------------------------------------------------
-- 01. AHUACHAPÁN (12 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Atiquizaya' AS nombre UNION ALL SELECT 'El Refugio' UNION ALL SELECT 'San Lorenzo' UNION ALL SELECT 'Turín'
) d WHERE m.id_departamento = 1 AND m.nombre = 'Ahuachapán Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Ahuachapán' AS nombre UNION ALL SELECT 'Apaneca' UNION ALL SELECT 'Concepción de Ataco' UNION ALL SELECT 'Tacuba'
) d WHERE m.id_departamento = 1 AND m.nombre = 'Ahuachapán Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Guaymango' AS nombre UNION ALL SELECT 'Jujutla' UNION ALL SELECT 'San Francisco Menéndez' UNION ALL SELECT 'San Pedro Puxtla'
) d WHERE m.id_departamento = 1 AND m.nombre = 'Ahuachapán Sur';

-- ----------------------------------------------------------------------------
-- 02. SANTA ANA (13 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Masahuat' AS nombre UNION ALL SELECT 'Metapán' UNION ALL SELECT 'Santa Rosa Guachipilín' UNION ALL SELECT 'Texistepeque'
) d WHERE m.id_departamento = 2 AND m.nombre = 'Santa Ana Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Santa Ana' AS nombre
) d WHERE m.id_departamento = 2 AND m.nombre = 'Santa Ana Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Coatepeque' AS nombre UNION ALL SELECT 'El Congo'
) d WHERE m.id_departamento = 2 AND m.nombre = 'Santa Ana Este';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Candelaria de la Frontera' AS nombre UNION ALL SELECT 'Chalchuapa' UNION ALL SELECT 'El Porvenir'
    UNION ALL SELECT 'San Antonio Pajonal' UNION ALL SELECT 'San Sebastián Salitrillo' UNION ALL SELECT 'Santiago de la Frontera'
) d WHERE m.id_departamento = 2 AND m.nombre = 'Santa Ana Oeste';

-- ----------------------------------------------------------------------------
-- 03. SONSONATE (16 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Juayúa' AS nombre UNION ALL SELECT 'Nahuizalco' UNION ALL SELECT 'Salcoatitán' UNION ALL SELECT 'Santa Catarina Masahuat'
) d WHERE m.id_departamento = 3 AND m.nombre = 'Sonsonate Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Sonsonate' AS nombre UNION ALL SELECT 'Sonzacate' UNION ALL SELECT 'Nahulingo'
    UNION ALL SELECT 'San Antonio del Monte' UNION ALL SELECT 'Santo Domingo de Guzmán'
) d WHERE m.id_departamento = 3 AND m.nombre = 'Sonsonate Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Armenia' AS nombre UNION ALL SELECT 'Caluco' UNION ALL SELECT 'Cuisnahuat'
    UNION ALL SELECT 'Izalco' UNION ALL SELECT 'San Julián' UNION ALL SELECT 'Santa Isabel Ishuatán'
) d WHERE m.id_departamento = 3 AND m.nombre = 'Sonsonate Este';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Acajutla' AS nombre
) d WHERE m.id_departamento = 3 AND m.nombre = 'Sonsonate Oeste';

-- ----------------------------------------------------------------------------
-- 04. CHALATENANGO (33 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'La Palma' AS nombre UNION ALL SELECT 'Citalá' UNION ALL SELECT 'San Ignacio'
) d WHERE m.id_departamento = 4 AND m.nombre = 'Chalatenango Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Nueva Concepción' AS nombre UNION ALL SELECT 'Tejutla' UNION ALL SELECT 'La Reina' UNION ALL SELECT 'Agua Caliente'
    UNION ALL SELECT 'Dulce Nombre de María' UNION ALL SELECT 'El Paraíso' UNION ALL SELECT 'San Francisco Morazán'
    UNION ALL SELECT 'San Rafael' UNION ALL SELECT 'Santa Rita' UNION ALL SELECT 'San Fernando'
) d WHERE m.id_departamento = 4 AND m.nombre = 'Chalatenango Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Chalatenango' AS nombre UNION ALL SELECT 'Arcatao' UNION ALL SELECT 'Azacualpa' UNION ALL SELECT 'Comalapa'
    UNION ALL SELECT 'Concepción Quezaltepeque' UNION ALL SELECT 'El Carrizal' UNION ALL SELECT 'La Laguna'
    UNION ALL SELECT 'Las Vueltas' UNION ALL SELECT 'Nombre de Jesús' UNION ALL SELECT 'Nueva Trinidad'
    UNION ALL SELECT 'Ojos de Agua' UNION ALL SELECT 'Potonico' UNION ALL SELECT 'San Antonio de la Cruz'
    UNION ALL SELECT 'San Antonio Los Ranchos' UNION ALL SELECT 'San Francisco Lempa' UNION ALL SELECT 'San Isidro Labrador'
    UNION ALL SELECT 'San José Cancasque' UNION ALL SELECT 'San Miguel de Mercedes' UNION ALL SELECT 'San José Las Flores'
    UNION ALL SELECT 'San Luis del Carmen'
) d WHERE m.id_departamento = 4 AND m.nombre = 'Chalatenango Sur';

-- ----------------------------------------------------------------------------
-- 05. LA LIBERTAD (22 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Quezaltepeque' AS nombre UNION ALL SELECT 'San Matías' UNION ALL SELECT 'San Pablo Tacachico'
) d WHERE m.id_departamento = 5 AND m.nombre = 'La Libertad Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'San Juan Opico' AS nombre UNION ALL SELECT 'Ciudad Arce'
) d WHERE m.id_departamento = 5 AND m.nombre = 'La Libertad Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Colón' AS nombre UNION ALL SELECT 'Jayaque' UNION ALL SELECT 'Sacacoyo'
    UNION ALL SELECT 'Tepecoyo' UNION ALL SELECT 'Talnique'
) d WHERE m.id_departamento = 5 AND m.nombre = 'La Libertad Oeste';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Antiguo Cuscatlán' AS nombre UNION ALL SELECT 'Huizúcar' UNION ALL SELECT 'Nuevo Cuscatlán'
    UNION ALL SELECT 'San José Villanueva' UNION ALL SELECT 'Zaragoza'
) d WHERE m.id_departamento = 5 AND m.nombre = 'La Libertad Este';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Chiltiupán' AS nombre UNION ALL SELECT 'Jicalapa' UNION ALL SELECT 'La Libertad'
    UNION ALL SELECT 'Tamanique' UNION ALL SELECT 'Teotepeque'
) d WHERE m.id_departamento = 5 AND m.nombre = 'La Libertad Costa';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Santa Tecla' AS nombre UNION ALL SELECT 'Comasagua'
) d WHERE m.id_departamento = 5 AND m.nombre = 'La Libertad Sur';

-- ----------------------------------------------------------------------------
-- 06. SAN SALVADOR (19 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Aguilares' AS nombre UNION ALL SELECT 'El Paisnal' UNION ALL SELECT 'Guazapa'
) d WHERE m.id_departamento = 6 AND m.nombre = 'San Salvador Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Apopa' AS nombre UNION ALL SELECT 'Nejapa'
) d WHERE m.id_departamento = 6 AND m.nombre = 'San Salvador Oeste';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Ilopango' AS nombre UNION ALL SELECT 'San Martín' UNION ALL SELECT 'Soyapango' UNION ALL SELECT 'Tonacatepeque'
) d WHERE m.id_departamento = 6 AND m.nombre = 'San Salvador Este';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Ayutuxtepeque' AS nombre UNION ALL SELECT 'Mejicanos' UNION ALL SELECT 'San Salvador'
    UNION ALL SELECT 'Cuscatancingo' UNION ALL SELECT 'Ciudad Delgado'
) d WHERE m.id_departamento = 6 AND m.nombre = 'San Salvador Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Panchimalco' AS nombre UNION ALL SELECT 'Rosario de Mora' UNION ALL SELECT 'San Marcos'
    UNION ALL SELECT 'Santo Tomás' UNION ALL SELECT 'Santiago Texacuangos'
) d WHERE m.id_departamento = 6 AND m.nombre = 'San Salvador Sur';

-- ----------------------------------------------------------------------------
-- 07. CUSCATLÁN (16 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Suchitoto' AS nombre UNION ALL SELECT 'San José Guayabal' UNION ALL SELECT 'Oratorio de Concepción'
    UNION ALL SELECT 'San Bartolomé Perulapía' UNION ALL SELECT 'San Pedro Perulapán'
) d WHERE m.id_departamento = 7 AND m.nombre = 'Cuscatlán Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Cojutepeque' AS nombre UNION ALL SELECT 'San Rafael Cedros' UNION ALL SELECT 'Candelaria'
    UNION ALL SELECT 'Monte San Juan' UNION ALL SELECT 'El Carmen' UNION ALL SELECT 'San Cristóbal'
    UNION ALL SELECT 'Santa Cruz Michapa' UNION ALL SELECT 'San Ramón' UNION ALL SELECT 'El Rosario'
    UNION ALL SELECT 'Santa Cruz Analquito' UNION ALL SELECT 'Tenancingo'
) d WHERE m.id_departamento = 7 AND m.nombre = 'Cuscatlán Sur';

-- ----------------------------------------------------------------------------
-- 08. LA PAZ (22 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Cuyultitán' AS nombre UNION ALL SELECT 'Olocuilta' UNION ALL SELECT 'San Juan Talpa'
    UNION ALL SELECT 'San Luis Talpa' UNION ALL SELECT 'San Pedro Masahuat' UNION ALL SELECT 'Tapalhuaca'
    UNION ALL SELECT 'San Francisco Chinameca'
) d WHERE m.id_departamento = 8 AND m.nombre = 'La Paz Oeste';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'El Rosario' AS nombre UNION ALL SELECT 'Jerusalén' UNION ALL SELECT 'Mercedes La Ceiba'
    UNION ALL SELECT 'Paraíso de Osorio' UNION ALL SELECT 'San Antonio Masahuat' UNION ALL SELECT 'San Emigdio'
    UNION ALL SELECT 'San Juan Tepezontes' UNION ALL SELECT 'San Luis La Herradura' UNION ALL SELECT 'San Miguel Tepezontes'
    UNION ALL SELECT 'San Pedro Nonualco' UNION ALL SELECT 'Santa María Ostuma' UNION ALL SELECT 'Santiago Nonualco'
) d WHERE m.id_departamento = 8 AND m.nombre = 'La Paz Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'San Juan Nonualco' AS nombre UNION ALL SELECT 'San Rafael Obrajuelo' UNION ALL SELECT 'Zacatecoluca'
) d WHERE m.id_departamento = 8 AND m.nombre = 'La Paz Este';

-- ----------------------------------------------------------------------------
-- 09. CABAÑAS (9 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Sensuntepeque' AS nombre UNION ALL SELECT 'Victoria' UNION ALL SELECT 'Dolores'
    UNION ALL SELECT 'Guacotecti' UNION ALL SELECT 'San Isidro'
) d WHERE m.id_departamento = 9 AND m.nombre = 'Cabañas Este';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Ilobasco' AS nombre UNION ALL SELECT 'Tejutepeque' UNION ALL SELECT 'Jutiapa' UNION ALL SELECT 'Cinquera'
) d WHERE m.id_departamento = 9 AND m.nombre = 'Cabañas Oeste';

-- ----------------------------------------------------------------------------
-- 10. SAN VICENTE (13 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Apastepeque' AS nombre UNION ALL SELECT 'Santa Clara' UNION ALL SELECT 'San Ildefonso'
    UNION ALL SELECT 'San Esteban Catarina' UNION ALL SELECT 'San Sebastián' UNION ALL SELECT 'San Lorenzo'
    UNION ALL SELECT 'Santo Domingo'
) d WHERE m.id_departamento = 10 AND m.nombre = 'San Vicente Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'San Vicente' AS nombre UNION ALL SELECT 'Guadalupe' UNION ALL SELECT 'Verapaz'
    UNION ALL SELECT 'Tepetitán' UNION ALL SELECT 'Tecoluca' UNION ALL SELECT 'San Cayetano Istepeque'
) d WHERE m.id_departamento = 10 AND m.nombre = 'San Vicente Sur';

-- ----------------------------------------------------------------------------
-- 11. USULUTÁN (23 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Santiago de María' AS nombre UNION ALL SELECT 'Alegría' UNION ALL SELECT 'Berlín'
    UNION ALL SELECT 'Mercedes Umaña' UNION ALL SELECT 'Jucuapa' UNION ALL SELECT 'El Triunfo'
    UNION ALL SELECT 'Estanzuelas' UNION ALL SELECT 'San Buenaventura' UNION ALL SELECT 'Nueva Granada'
) d WHERE m.id_departamento = 11 AND m.nombre = 'Usulután Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Usulután' AS nombre UNION ALL SELECT 'Jucuarán' UNION ALL SELECT 'San Dionisio'
    UNION ALL SELECT 'Concepción Batres' UNION ALL SELECT 'Santa María' UNION ALL SELECT 'Ozatlán'
    UNION ALL SELECT 'Tecapán' UNION ALL SELECT 'Santa Elena' UNION ALL SELECT 'California'
    UNION ALL SELECT 'Ereguayquín'
) d WHERE m.id_departamento = 11 AND m.nombre = 'Usulután Este';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Jiquilisco' AS nombre UNION ALL SELECT 'Puerto El Triunfo' UNION ALL SELECT 'San Agustín'
    UNION ALL SELECT 'San Francisco Javier'
) d WHERE m.id_departamento = 11 AND m.nombre = 'Usulután Oeste';

-- ----------------------------------------------------------------------------
-- 12. SAN MIGUEL (20 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Ciudad Barrios' AS nombre UNION ALL SELECT 'Sesori' UNION ALL SELECT 'Nuevo Edén de San Juan'
    UNION ALL SELECT 'San Gerardo' UNION ALL SELECT 'San Luis de la Reina' UNION ALL SELECT 'Carolina'
    UNION ALL SELECT 'San Antonio del Mosco' UNION ALL SELECT 'Chapeltique'
) d WHERE m.id_departamento = 12 AND m.nombre = 'San Miguel Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'San Miguel' AS nombre UNION ALL SELECT 'Comacarán' UNION ALL SELECT 'Uluazapa'
    UNION ALL SELECT 'Moncagua' UNION ALL SELECT 'Quelepa' UNION ALL SELECT 'Chirilagua'
) d WHERE m.id_departamento = 12 AND m.nombre = 'San Miguel Centro';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Chinameca' AS nombre UNION ALL SELECT 'Nueva Guadalupe' UNION ALL SELECT 'Lolotique'
    UNION ALL SELECT 'San Jorge' UNION ALL SELECT 'San Rafael Oriente' UNION ALL SELECT 'El Tránsito'
) d WHERE m.id_departamento = 12 AND m.nombre = 'San Miguel Oeste';

-- ----------------------------------------------------------------------------
-- 13. MORAZÁN (26 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Arambala' AS nombre UNION ALL SELECT 'Cacaopera' UNION ALL SELECT 'Corinto'
    UNION ALL SELECT 'El Rosario' UNION ALL SELECT 'Joateca' UNION ALL SELECT 'Jocoaitique'
    UNION ALL SELECT 'Meanguera' UNION ALL SELECT 'Perquín' UNION ALL SELECT 'San Fernando'
    UNION ALL SELECT 'San Isidro' UNION ALL SELECT 'Torola'
) d WHERE m.id_departamento = 13 AND m.nombre = 'Morazán Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'San Francisco Gotera' AS nombre UNION ALL SELECT 'Chilanga' UNION ALL SELECT 'Delicias de Concepción'
    UNION ALL SELECT 'El Divisadero' UNION ALL SELECT 'Gualococti' UNION ALL SELECT 'Guatajiagua'
    UNION ALL SELECT 'Jocoro' UNION ALL SELECT 'Lolotiquillo' UNION ALL SELECT 'Osicala'
    UNION ALL SELECT 'San Carlos' UNION ALL SELECT 'San Simón' UNION ALL SELECT 'Sensembra'
    UNION ALL SELECT 'Sociedad' UNION ALL SELECT 'Yamabal' UNION ALL SELECT 'Yoloaiquín'
) d WHERE m.id_departamento = 13 AND m.nombre = 'Morazán Sur';

-- ----------------------------------------------------------------------------
-- 14. LA UNIÓN (18 distritos)
-- ----------------------------------------------------------------------------
INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'Anamorós' AS nombre UNION ALL SELECT 'Bolívar' UNION ALL SELECT 'Concepción de Oriente'
    UNION ALL SELECT 'El Sauce' UNION ALL SELECT 'Lislique' UNION ALL SELECT 'Nueva Esparta'
    UNION ALL SELECT 'Pasaquina' UNION ALL SELECT 'Polorós' UNION ALL SELECT 'San José La Fuente'
    UNION ALL SELECT 'Santa Rosa de Lima'
) d WHERE m.id_departamento = 14 AND m.nombre = 'La Unión Norte';

INSERT IGNORE INTO ctl_distrito (id_municipio, nombre)
SELECT m.id_municipio, d.nombre FROM ctl_municipio m
CROSS JOIN (
    SELECT 'La Unión' AS nombre UNION ALL SELECT 'Conchagua' UNION ALL SELECT 'El Carmen'
    UNION ALL SELECT 'Intipucá' UNION ALL SELECT 'Meanguera del Golfo' UNION ALL SELECT 'San Alejo'
    UNION ALL SELECT 'Yayantique' UNION ALL SELECT 'Yucuaiquín'
) d WHERE m.id_departamento = 14 AND m.nombre = 'La Unión Sur';


