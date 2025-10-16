create database leshealth;
use leshealth;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(30) DEFAULT NULL,
  `clave` varchar(150) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB;

select *from usuario;

 create table departamento(
 id_departamento int auto_increment primary key,
 nombre_departamento varchar(50) NOT NULL
 )engine=InnoDB;

 create table municipio(
 id_municipio int auto_increment primary key,
 nombre_municipio varchar(70) NOT NULL,
 departamento_id_departamento int,
 foreign key(departamento_id_departamento)references departamento(id_departamento) on delete set null on update cascade
 )engine=InnoDB;



CREATE TABLE protagonista (
  id_paciente INT AUTO_INCREMENT PRIMARY KEY,
  primer_nombre VARCHAR(255) NOT NULL,
  segundo_nombre VARCHAR(255),
  primer_apellido VARCHAR(255) NOT NULL,
  segundo_apellido VARCHAR(255),
  cedula VARCHAR(14) UNIQUE,
  municipio INT,
  fecha_nacimiento DATE,
  edad INT,
  sexo ENUM('Masculino', 'Femenino'),
  nacionalidad ENUM('Nicaraguense', 'Extranjero'),
  estado_civil ENUM('Union Libre', 'Casado', 'Soltero', 'Otro'),
  ocupacion VARCHAR(255),
  direccion text,
  correo VARCHAR (45) NOT NULL,
  telefono VARCHAR (45) NOT NULL,
  usuario VARCHAR (255) NOT NULL,
  imagen varchar(50)
)engine=InnoDB;


create table doctor(
	id_doctor INT PRIMARY KEY AUTO_INCREMENT,
    nombre_doctor VARCHAR (45) NOT NULL,
    sexo VARCHAR (45) NOT NULL,
    especialidad VARCHAR (45) NOT NULL,
    correo VARCHAR (45) NOT NULL,
    telefono VARCHAR (45) NOT NULL,
    usuario VARCHAR (255) NOT NULL,
    imagen varchar(50)
)engine=InnoDB;

create table reserva(
id_cita int primary key auto_increment,
hora time,
fecha date,
doctor_id_doctor int,
protagonista_id_protagonista int,
motivo varchar(45),
prioridad varchar(45),
imagen varchar(20),
estado varchar(45),
foreign key (doctor_id_doctor) references doctor(id_doctor),
foreign key (protagonista_id_protagonista) references protagonista(id_paciente)
)engine=InnoDB;
alter table reserva add column estado varchar(45);  



select *from reserva;
select *from reserva inner join doctor on id_doctor=doctor_id_doctor inner join protagonista on protagonista_id_protagonista=id_paciente where id_doctor=4;
select *from doctor where usuario='fanor';
select *from reserva inner join doctor on id_doctor=doctor_id_doctor inner join protagonista on protagonista_id_protagonista=id_paciente where id_doctor=7 and estado='sin aceptar';
describe reserva;
create table cita(
id_cita int primary key auto_increment,
hora time,
fecha date,
motivo text,
presion varchar(45),
tipo varchar(20),


)engine=InnoDB;

create table confirmacion(
id_confirmarcion int primary key auto_increment,
doctor_id_doctor int,
protagonista_id_protagonista int,
id_cita_confirmacion int,
foreign key (doctor_id_doctor) references doctor(id_doctor),
foreign key (protagonista_id_protagonista) references protagonista(id_paciente),
foreign key (id_cita_confirmacion) references reserva(id_cita)
)engine=InnoDB;

describe confirmacion;
select *from confirmacion;

select *from confirmacion inner join doctor on doctor_id_doctor=id_doctor inner join protagonista on protagonista_id_protagonista=id_paciente inner join reserva on id_cita_confirmacion=id_cita where id_doctor=7 and estado='aceptada';


create table medicacion(
id_medicacion int primary key auto_increment,
nombre_medicamento varchar(45),
dosis varchar(45),
frecuencia varchar(45),
hora_aplicacion time,
fecha date,
duracion varchar(45),
protagonista_id_protagonista int,
imagenMedicina varchar(20),
foreign key (protagonista_id_protagonista) references protagonista(id_paciente)
)engine=InnoDB;

create table dieta(
id_dieta int primary key auto_increment,
nombre_plato varchar(45),
tipo varchar(45),
descripcion varchar(45),
protagonista_id_protagonista int,
imagen_platillo varchar(20),
foreign key (protagonista_id_protagonista) references protagonista(id_paciente)
)engine=InnoDB;

create table ejercicio(
id_ejercicio int primary key auto_increment,
nombre_ejercicio varchar(45),
repeticiones varchar(45),
series varchar(45),
protagonista_id_protagonista int,
imagen_ejercicio varchar(20),
foreign key (protagonista_id_protagonista) references protagonista(id_paciente)
)engine=InnoDB;

create table signos(
id_signo int primary key auto_increment,
fecha date,
hora time,
tipo varchar(45),
valor varchar(20),
protagonista_id_protagonista int,
foreign key (protagonista_id_protagonista) references protagonista(id_paciente)
)engine=InnoDB;


--
-- Volcado de datos para la tabla `protagonista`
--

INSERT INTO `protagonista` (`id_paciente`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `cedula`, `municipio`, `fecha_nacimiento`, `edad`, `sexo`, `nacionalidad`, `estado_civil`, `ocupacion`, `direccion`, `correo`, `telefono`, `usuario`, `imagen`) VALUES
(1, 'Alexa', 'Maria', 'Perez', 'Estrada', '12312312', 1, '1998-09-02', 25, 'Femenino', 'Nicaraguense', 'Casado', 'estudia', 'sector #16 de somoto 1 C entrada principal', 'alexa@gmail.com', '27222222', 'alexa', '924281481.png');


--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre_departamento`) VALUES
(1, 'Madriz'),
(2, 'Nueva segovia'),
(5, 'Managua'),
(6, 'León'),
(7, 'Granada'),
(8, 'Masaya'),
(9, 'Chinandega');



--
-- Volcado de datos para la tabla `dieta`
--

INSERT INTO `dieta` (`id_dieta`, `nombre_plato`, `tipo`, `descripcion`, `protagonista_id_protagonista`, `imagen_platillo`) VALUES
(2, 'Ensalada de vegetales', 'Vegetariano', 'Vegetales frescos ricos en antioxidantes', 1, '1.jpg'),
(3, 'Salmón al horno', 'Proteína', 'Salmón con especias y limón', 1, '2.jpg'),
(4, 'Avena con frutas', 'Desayuno', 'Avena integral con fresas y plátano', 1, '3.jpg'),
(5, 'Pollo a la plancha', 'Proteína', 'Pollo sin grasa acompañado de verduras', 1, '4.jpg'),
(6, 'Smoothie verde', 'Bebida', 'Batido de espinaca, manzana y pepino', 1, '5.jpg');




--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `nombre_doctor`, `sexo`, `especialidad`, `correo`, `telefono`, `usuario`, `imagen`) VALUES
(2, 'Dr. Carlos Méndez', 'Masculino', 'Reumatología', 'cmendez@hospitalnica.com', '2222-3344', 'cmendez', '22.jpg'),
(3, 'Dra. Ana López', 'Femenino', 'Inmunología', 'alopez@hospitalnica.com', '2222-4455', 'alopez', '20.jpg'),
(4, 'Dr. Juan Pérez', 'Masculino', 'Medicina Interna', 'jperez@hospitalnica.com', '2222-5566', 'jperez', '24.jpg'),
(5, 'Dra. María González', 'Femenino', 'Endocrinología', 'mgonzalez@hospitalnica.com', '2222-6677', 'mgonzalez', '21.jpg'),
(6, 'Dr. Luis Ramírez', 'Masculino', 'Medicina General', 'lramirez@hospitalnica.com', '2222-7788', 'lramirez', '23.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio`
--



--
-- Volcado de datos para la tabla `ejercicio`
--

INSERT INTO `ejercicio` (`id_ejercicio`, `nombre_ejercicio`, `repeticiones`, `series`, `protagonista_id_protagonista`, `imagen_ejercicio`) VALUES
(2, 'Caminar', '30 minutos', '1', 1, '11.jpg'),
(3, 'Estiramientos suaves', '10', '2', 1, '12.png'),
(4, 'Yoga para principiantes', '20 minutos', '1', 1, '13.jpg'),
(5, 'Natación ligera', '15 minutos', '1', 1, '14.jpeg'),
(6, 'Bicicleta estática', '20 minutos', '1', 1, '15.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--


-- Volcado de datos para la tabla `medicacion`
--

INSERT INTO `medicacion` (`id_medicacion`, `nombre_medicamento`, `dosis`, `frecuencia`, `hora_aplicacion`, `fecha`, `duracion`, `protagonista_id_protagonista`, `imagenMedicina`) VALUES
(7, 'Hidroxicloroquina', '200mg', '1 vez al día', '08:00:00', '2025-09-25', '30 días', 1, '6.png'),
(8, 'Prednisona', '10mg', '2 veces al día', '08:00:00', '2025-09-25', '14 días', 1, '7.png'),
(9, 'Metotrexato', '15mg', '1 vez a la semana', '09:00:00', '2025-09-25', '8 semanas', 1, '8.jpg'),
(10, 'Azatioprina', '50mg', '1 vez al día', '07:30:00', '2025-09-25', '30 días', 1, '9.png'),
(11, 'Naproxeno', '250mg', '2 veces al día', '08:30:00', '2025-09-25', '10 días', 1, '10.jpg');

-- --------------------------------------------------------


--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_municipio`, `nombre_municipio`, `departamento_id_departamento`) VALUES
(1, 'Somoto', 1),
(2, 'San Lucas', 1),
(3, 'Ocotal', 2),
(4, 'Esteli', 2);






--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_cita`, `hora`, `fecha`, `doctor_id_doctor`, `protagonista_id_protagonista`, `motivo`, `prioridad`, `imagen`) VALUES
(5, '08:00:00', '2025-09-26', 4, 1, 'Consulta Rutinaria', 'Media', '1292103067.png');




--
-- Volcado de datos para la tabla `signos`
--

INSERT INTO `signos` (`id_signo`, `fecha`, `hora`, `tipo`, `valor`, `protagonista_id_protagonista`) VALUES
(1, '2025-09-02', '00:58:43', 'glucosa', '20', 1),
(12, '2025-09-25', '08:00:00', 'glucosa', '95', 1),
(13, '2025-09-25', '08:30:00', 'presion', '120', 1),
(14, '2025-09-25', '09:00:00', 'glucosa', '110', 1),
(15, '2025-09-25', '09:30:00', 'presion', '130', 1),
(16, '2025-09-25', '10:00:00', 'glucosa', '100', 1),
(17, '2025-09-25', '10:30:00', 'presion', '125', 1),
(18, '2025-09-25', '11:00:00', 'glucosa', '98', 1),
(19, '2025-09-25', '11:30:00', 'presion', '118', 1),
(20, '2025-09-25', '12:00:00', 'glucosa', '105', 1),
(21, '2025-09-25', '12:30:00', 'presion', '122', 1);

-- --------------------------------------------------------






INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `clave`, `rol`) VALUES
(1, 'rodrix', '123', 'administrador'),
(2, 'rodrigo', '$2y$10$IeIPo0TTyM1qnn.EeN9sSuPvx2AzLneFApczc82IBWE98bzu6NhXm', 'administrador'),
(3, 'josue', '$2y$10$YmKHs6p9hrqTEFEnUuUQgeUSPdI7Ou.5fYMmgVjmXaQqXJK.FNMAK', 'administrador'),
(4, 'juan', '$2y$10$cy2AR5REHwisIQsBPd7M6O752CW/x3Xcnaw7SYJ3...dReskxus3e', 'familiar'),
(5, 'raul', '$2y$10$ycJRnb7wP4iicVui5NKz6elXUAh4LB2oXDkdTUH6qaArzEtrGp.Mi', 'familiar'),
(6, 'luis', '$2y$10$LbmsPLsnaNgdNjR.nayIC.sUTG8OatviDSXGrIiLM5M9v/6h5RaNi', 'familiar'),
(7, 'pedro', '$2y$10$eGcES9eS/3k8Zrdn0c.GSemdQelKG27Zm34VUbOFDoCCiEMlDzHJC', 'familiar'),
(8, 'renaldy', '123', 'doctor'),
(9, 'alexa', '$2y$10$LPaN.smCzD3oXLOR4FR/l.awwRWqvubB0cZvaH4fM5TXS3ks6ZntK', 'protagonista');