-- Sequence: user_id_sequence

-- DROP SEQUENCE user_id_sequence;

CREATE SEQUENCE user_id_sequence
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 2
  CACHE 1;

-- Table: usuarios

-- DROP TABLE usuarios;

CREATE TABLE usuarios
(
  usuario d_usuario NOT NULL DEFAULT nextval('user_id_sequence'::regclass),
  nombres d_nombre_usuario NOT NULL,
  apellidos d_apellido_usuario NOT NULL,
  fecha_nacimiento d_fecha,
  sexo d_sexo NOT NULL,
  direccion d_direccion NOT NULL,
  telefono d_telefono NOT NULL,
  email d_direccion_email,
  password d_contrasena NOT NULL,
  state d_estado_cuenta,
  username character varying(255),
  documento character varying(30),
  tipo_doc integer,
  display_name character varying(255),
  CONSTRAINT pk_usuarios PRIMARY KEY (usuario)
)