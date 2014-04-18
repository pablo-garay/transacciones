/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     4/18/2014 6:26:34 PM                         */
/*==============================================================*/

/*==============================================================*/
/* Table: ALUMNOS                                               */
/*==============================================================*/
create table ALUMNOS (
   CEDULA               INT4                 not null,
   USUARIO              INT4                 not null,
   constraint PK_ALUMNOS primary key (CEDULA)
);

/*==============================================================*/
/* Index: ALUMNOS_PK                                            */
/*==============================================================*/
create unique index ALUMNOS_PK on ALUMNOS (
CEDULA
);

/*==============================================================*/
/* Table: ALUMNOS_POR_TESIS                                     */
/*==============================================================*/
create table ALUMNOS_POR_TESIS (
   SOLICITUD            INT4                 not null,
   CEDULA               INT4                 not null,
   constraint PK_ALUMNOS_POR_TESIS primary key (SOLICITUD, CEDULA)
);

/*==============================================================*/
/* Index: INCLUYE_INTEGRANTES_PK                                */
/*==============================================================*/
create unique index INCLUYE_INTEGRANTES_PK on ALUMNOS_POR_TESIS (
SOLICITUD,
CEDULA
);

/*==============================================================*/
/* Index: INCLUYE_INTEGRANTES_FK                                */
/*==============================================================*/
create  index INCLUYE_INTEGRANTES_FK on ALUMNOS_POR_TESIS (
SOLICITUD
);

/*==============================================================*/
/* Index: INCLUYE_INTEGRANTES_FK2                               */
/*==============================================================*/
create  index INCLUYE_INTEGRANTES_FK2 on ALUMNOS_POR_TESIS (
CEDULA
);

/*==============================================================*/
/* Table: ARCHIVOS_ADJUNTOS                                     */
/*==============================================================*/
create table ARCHIVOS_ADJUNTOS (
   CORREO               INT4                 not null,
   NUMERO               SERIAL not null,
   OBJETO_ADJUNTO       CHAR(255)            not null,
   constraint PK_ARCHIVOS_ADJUNTOS primary key (CORREO, NUMERO)
);

/*==============================================================*/
/* Index: ARCHIVOS_ADJUNTOS_PK                                  */
/*==============================================================*/
create unique index ARCHIVOS_ADJUNTOS_PK on ARCHIVOS_ADJUNTOS (
CORREO,
NUMERO
);

/*==============================================================*/
/* Index: CONTIENE_FK                                           */
/*==============================================================*/
create  index CONTIENE_FK on ARCHIVOS_ADJUNTOS (
CORREO
);

/*==============================================================*/
/* Table: CORREOS_ELECTRONICOS                                  */
/*==============================================================*/
create table CORREOS_ELECTRONICOS (
   CORREO               SERIAL not null,
   USUARIO              INT4                 not null,
   DESTINATARIO         CHAR(255)            not null,
   REMITENTE            CHAR(255)            not null,
   CUERPO               TEXT                 not null,
   constraint PK_CORREOS_ELECTRONICOS primary key (CORREO)
);

/*==============================================================*/
/* Index: CORREOS_ELECTRONICOS_PK                               */
/*==============================================================*/
create unique index CORREOS_ELECTRONICOS_PK on CORREOS_ELECTRONICOS (
CORREO
);

/*==============================================================*/
/* Index: POSEE_FK                                              */
/*==============================================================*/
create  index POSEE_FK on CORREOS_ELECTRONICOS (
USUARIO
);

/*==============================================================*/
/* Table: CREDITOS_POR_CARRERA                                  */
/*==============================================================*/
create table CREDITOS_POR_CARRERA (
   CARRERA              INT4                 not null,
   NOMBRE               CHAR(80)             not null,
   CREDITOS_REQUERIDOS  INT4                 null
      constraint CKC_CREDITOS_REQUERID_CREDITOS check (CREDITOS_REQUERIDOS is null or (CREDITOS_REQUERIDOS >= 0)),
   constraint PK_CREDITOS_POR_CARRERA primary key (CARRERA)
);

/*==============================================================*/
/* Index: CREDITOS_POR_CARRERA_PK                               */
/*==============================================================*/
create unique index CREDITOS_POR_CARRERA_PK on CREDITOS_POR_CARRERA (
CARRERA
);

/*==============================================================*/
/* Table: DOCUMENTOS_ADJUNTOS                                   */
/*==============================================================*/
create table DOCUMENTOS_ADJUNTOS (
   ID_DOCUMENTO         SERIAL not null,
   SOLICITUD            INT4                 not null,
   FECHA_ADJUNTO        DATE                 not null,
   ARCHIVO              CHAR(255)            not null,
   constraint PK_DOCUMENTOS_ADJUNTOS primary key (ID_DOCUMENTO)
);

/*==============================================================*/
/* Index: DOCUMENTOS_ADJUNTOS_PK                                */
/*==============================================================*/
create unique index DOCUMENTOS_ADJUNTOS_PK on DOCUMENTOS_ADJUNTOS (
ID_DOCUMENTO
);

/*==============================================================*/
/* Index: TIENE_FK                                              */
/*==============================================================*/
create  index TIENE_FK on DOCUMENTOS_ADJUNTOS (
SOLICITUD
);

/*==============================================================*/
/* Table: FECHAS_DE_RESOLUCION_DE_SOLICITUDES                   */
/*==============================================================*/
create table FECHAS_DE_RESOLUCION_DE_SOLICITUDES (
   SOLICITUD            INT4                 not null,
   FECHA_RESOLUCION     DATE                 not null,
   constraint PK_FECHAS_DE_RESOLUCION_DE_SOL primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: FECHAS_DE_RESOLUCION_DE_SOLICITUDES_PK                */
/*==============================================================*/
create unique index FECHAS_DE_RESOLUCION_DE_SOLICITUDES_PK on FECHAS_DE_RESOLUCION_DE_SOLICITUDES (
SOLICITUD
);

/*==============================================================*/
/* Table: HISTORIAL_EXTRAORDINARIOS                             */
/*==============================================================*/
create table HISTORIAL_EXTRAORDINARIOS (
   HISTORIAL            SERIAL not null,
   CEDULA               INT4                 not null,
   MATERIA              CHAR(80)             not null,
   FECHA_HORA           DATE                 not null,
   constraint PK_HISTORIAL_EXTRAORDINARIOS primary key (HISTORIAL)
);

/*==============================================================*/
/* Index: HISTORIAL_EXTRAORDINARIOS_PK                          */
/*==============================================================*/
create unique index HISTORIAL_EXTRAORDINARIOS_PK on HISTORIAL_EXTRAORDINARIOS (
HISTORIAL
);

/*==============================================================*/
/* Index: TIENE_FK2                                             */
/*==============================================================*/
create  index TIENE_FK2 on HISTORIAL_EXTRAORDINARIOS (
CEDULA
);

/*==============================================================*/
/* Table: LOGS                                                  */
/*==============================================================*/
create table LOGS (
   ID                   SERIAL not null,
   USUARIO              INT4                 null,
   PARAMETRO            INT4                 null,
   FECHA_CREADO         DATE                 not null,
   CONTENIDO            TEXT                 not null,
   constraint PK_LOGS primary key (ID)
);

/*==============================================================*/
/* Index: LOGS_PK                                               */
/*==============================================================*/
create unique index LOGS_PK on LOGS (
ID
);

/*==============================================================*/
/* Index: ACCEDE_A_FK                                           */
/*==============================================================*/
create  index ACCEDE_A_FK on LOGS (
USUARIO
);

/*==============================================================*/
/* Index: GENERADO_SEGUN_FK                                     */
/*==============================================================*/
create  index GENERADO_SEGUN_FK on LOGS (
PARAMETRO
);

/*==============================================================*/
/* Table: PARAMETROS_LOGS                                       */
/*==============================================================*/
create table PARAMETROS_LOGS (
   PARAMETRO            SERIAL not null,
   NOMBRE_LOG           CHAR(80)             not null,
   TIEMPO_DE_ACTUALIZACION TIME                 not null,
   DESCRIPCION          TEXT                 null,
   constraint PK_PARAMETROS_LOGS primary key (PARAMETRO)
);

/*==============================================================*/
/* Index: PARAMETROS_LOGS_PK                                    */
/*==============================================================*/
create unique index PARAMETROS_LOGS_PK on PARAMETROS_LOGS (
PARAMETRO
);

/*==============================================================*/
/* Table: PERMISOS                                              */
/*==============================================================*/
create table PERMISOS (
   PERMISO              SERIAL not null,
   NOMBRE               CHAR(80)             not null,
   DESCRIPCION          TEXT                 null,
   constraint PK_PERMISOS primary key (PERMISO)
);

/*==============================================================*/
/* Index: PERMISOS_PK                                           */
/*==============================================================*/
create unique index PERMISOS_PK on PERMISOS (
PERMISO
);

/*==============================================================*/
/* Table: PERMISOS_POR_ROL                                      */
/*==============================================================*/
create table PERMISOS_POR_ROL (
   ROL                  INT4                 not null,
   PERMISO              INT4                 not null,
   constraint PK_PERMISOS_POR_ROL primary key (ROL, PERMISO)
);

/*==============================================================*/
/* Index: CONTIENE_PK                                           */
/*==============================================================*/
create unique index CONTIENE_PK on PERMISOS_POR_ROL (
ROL,
PERMISO
);

/*==============================================================*/
/* Index: CONTIENE_FK2                                          */
/*==============================================================*/
create  index CONTIENE_FK2 on PERMISOS_POR_ROL (
ROL
);

/*==============================================================*/
/* Index: CONTIENE_FK3                                          */
/*==============================================================*/
create  index CONTIENE_FK3 on PERMISOS_POR_ROL (
PERMISO
);

/*==============================================================*/
/* Table: ROLES                                                 */
/*==============================================================*/
create table ROLES (
   ROL                  SERIAL not null,
   NOMBRE_ROL           CHAR(80)             not null,
   constraint PK_ROLES primary key (ROL)
);

/*==============================================================*/
/* Index: ROLES_PK                                              */
/*==============================================================*/
create unique index ROLES_PK on ROLES (
ROL
);

/*==============================================================*/
/* Table: ROLES_POR_USUARIO                                     */
/*==============================================================*/
create table ROLES_POR_USUARIO (
   USUARIO              INT4                 not null,
   ROL                  INT4                 not null,
   constraint PK_ROLES_POR_USUARIO primary key (USUARIO, ROL)
);

/*==============================================================*/
/* Index: TIENE_ASIGNADO_PK                                     */
/*==============================================================*/
create unique index TIENE_ASIGNADO_PK on ROLES_POR_USUARIO (
USUARIO,
ROL
);

/*==============================================================*/
/* Index: TIENE_ASIGNADO_FK                                     */
/*==============================================================*/
create  index TIENE_ASIGNADO_FK on ROLES_POR_USUARIO (
USUARIO
);

/*==============================================================*/
/* Index: TIENE_ASIGNADO_FK2                                    */
/*==============================================================*/
create  index TIENE_ASIGNADO_FK2 on ROLES_POR_USUARIO (
ROL
);

/*==============================================================*/
/* Table: SOLICITUDES                                           */
/*==============================================================*/
create table SOLICITUDES (
   SOLICITUD            SERIAL not null,
   USUARIO_SOLICITANTE  INT4                 not null,
   MESA_ENTRADA         INT4                 not null,
   CARRERA              CHAR(80)             not null,
   MATERIA              CHAR(80)             null,
   FECHA_SOLICITADA     DATE                 not null,
   ESTADO_SOLICITUD     CHAR(6)              null
      constraint CKC_ESTADO_SOLICITUD_SOLICITU check (ESTADO_SOLICITUD is null or (ESTADO_SOLICITUD in ('APR','REC','ANUL','NUEVO','PEND','CANCEL'))),
   ETAPA_ACTUAL         CHAR(6)              not null
      constraint CKC_ETAPA_ACTUAL_SOLICITU check (ETAPA_ACTUAL in ('DEL_DE','DEL_DA','DEL_DD','DEL_SA','DEL_SD','DEL_SG','RCDA','FINAL')),
   OBSERVACIONES        TEXT                 null,
   RESULTADO_REQUISITOS CHAR(13)             not null
      constraint CKC_RESULTADO_REQUISI_SOLICITU check (RESULTADO_REQUISITOS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUDES primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUDES_PK                                        */
/*==============================================================*/
create unique index SOLICITUDES_PK on SOLICITUDES (
SOLICITUD
);

/*==============================================================*/
/* Index: HECHA_POR_FK                                          */
/*==============================================================*/
create  index HECHA_POR_FK on SOLICITUDES (
USUARIO_SOLICITANTE
);

/*==============================================================*/
/* Table: SOLICITUDES_POR_FUNCIONARIO                           */
/*==============================================================*/
create table SOLICITUDES_POR_FUNCIONARIO (
   USUARIO              INT4                 not null,
   SOLICITUD            INT4                 not null,
   constraint PK_SOLICITUDES_POR_FUNCIONARIO primary key (USUARIO, SOLICITUD)
);

/*==============================================================*/
/* Index: ACCEDEN_A_PK                                          */
/*==============================================================*/
create unique index ACCEDEN_A_PK on SOLICITUDES_POR_FUNCIONARIO (
USUARIO,
SOLICITUD
);

/*==============================================================*/
/* Index: ACCEDEN_A_FK                                          */
/*==============================================================*/
create  index ACCEDEN_A_FK on SOLICITUDES_POR_FUNCIONARIO (
USUARIO
);

/*==============================================================*/
/* Index: ACCEDEN_A_FK2                                         */
/*==============================================================*/
create  index ACCEDEN_A_FK2 on SOLICITUDES_POR_FUNCIONARIO (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUDES_VARIAS                                    */
/*==============================================================*/
create table SOLICITUDES_VARIAS (
   SOLICITUD            INT4                 not null,
   ASUNTO               CHAR(80)             not null,
   MOTIVO               TEXT                 not null,
   constraint PK_SOLICITUDES_VARIAS primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUDES_VARIAS_PK                                 */
/*==============================================================*/
create unique index SOLICITUDES_VARIAS_PK on SOLICITUDES_VARIAS (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_CAMBIO_DE_SECCION                        */
/*==============================================================*/
create table SOLICITUD_DE_CAMBIO_DE_SECCION (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   MATERIA_SECCION_VALIDAS CHAR(13)             not null
      constraint CKC_MATERIA_SECCION_V_SOLICITU check (MATERIA_SECCION_VALIDAS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_CAMBIO_DE_SECC primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_CAMBIO_DE_SECCION_PK                     */
/*==============================================================*/
create unique index SOLICITUD_DE_CAMBIO_DE_SECCION_PK on SOLICITUD_DE_CAMBIO_DE_SECCION (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_CERTIFICADO_DE_ESTUDIOS                  */
/*==============================================================*/
create table SOLICITUD_DE_CERTIFICADO_DE_ESTUDIOS (
   SOLICITUD            INT4                 not null,
   TIPO_DE_CERTIFICADO  CHAR(1)              not null
      constraint CKC_TIPO_DE_CERTIFICA_SOLICITU check (TIPO_DE_CERTIFICADO in ('S','L')),
   TIPO_DE_TITULO       CHAR(15)             not null
      constraint CKC_TIPO_DE_TITULO_SOLICITU check (TIPO_DE_TITULO in ('Arquitecto','Ingeniero','Master','Licenciado','Programador','Tecnico','Especializacion','Completo','Incompleto')),
   APROBACION_PLAN_MATERIAS CHAR(13)             not null
      constraint CKC_APROBACION_PLAN_M_SOLICITU check (APROBACION_PLAN_MATERIAS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   PRESENTACION_CERTIFICADO_ESTUDIOS CHAR(13)             not null
      constraint CKC_PRESENTACION_CERT_SOLICITU check (PRESENTACION_CERTIFICADO_ESTUDIOS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_CERTIFICADO_DE primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_CERTIFICADO_DE_ESTUDIOS_PK               */
/*==============================================================*/
create unique index SOLICITUD_DE_CERTIFICADO_DE_ESTUDIOS_PK on SOLICITUD_DE_CERTIFICADO_DE_ESTUDIOS (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_COLABORADOR_DE_CATEDRA                   */
/*==============================================================*/
create table SOLICITUD_DE_COLABORADOR_DE_CATEDRA (
   SOLICITUD            INT4                 not null,
   DESCRIPCION_ACTIVIDADES TEXT                 not null,
   MATERIA_CURSADA      CHAR(13)             not null
      constraint CKC_MATERIA_CURSADA_SOLICITU check (MATERIA_CURSADA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   NOTA_MINIMA_REQUERIDA CHAR(13)             not null
      constraint CKC_NOTA_MINIMA_REQUE_SOLICITU check (NOTA_MINIMA_REQUERIDA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   AYUDANTE_COLABORADOR BOOL                 not null,
   SOLICITANTE_LICENCIADO_ULTIMO_ANHO CHAR(13)             null
      constraint CKC_SOLICITANTE_LICEN_SOLICITU check (SOLICITANTE_LICENCIADO_ULTIMO_ANHO is null or (SOLICITANTE_LICENCIADO_ULTIMO_ANHO in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE'))),
   constraint PK_SOLICITUD_DE_COLABORADOR_DE primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_COLABORADOR_DE_CATEDRA_PK                */
/*==============================================================*/
create unique index SOLICITUD_DE_COLABORADOR_DE_CATEDRA_PK on SOLICITUD_DE_COLABORADOR_DE_CATEDRA (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_CONVALIDACION_DE_MATERIAS                */
/*==============================================================*/
create table SOLICITUD_DE_CONVALIDACION_DE_MATERIAS (
   SOLICITUD            INT4                 not null,
   UNIVERSIDAD_ORIGEN   CHAR(40)             not null,
   DIRECCION_UNIVERSIDAD_ORIGEN VARCHAR(120)         not null,
   TELEFONO_UNIVERSIDAD_ORIGEN VARCHAR(30)          not null,
   EMAIL_UNIVERSIDAD_ORIGEN CHAR(255)            not null,
   CARRERA_CURSADA_UNIVERSIDAD_ORIGEN CHAR(80)             not null,
   constraint PK_SOLICITUD_DE_CONVALIDACION_ primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_CONVALIDACION_DE_MATERIAS_PK             */
/*==============================================================*/
create unique index SOLICITUD_DE_CONVALIDACION_DE_MATERIAS_PK on SOLICITUD_DE_CONVALIDACION_DE_MATERIAS (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_CREDITOS_ACADEMICOS                      */
/*==============================================================*/
create table SOLICITUD_DE_CREDITOS_ACADEMICOS (
   SOLICITUD            INT4                 not null,
   DESCRIPCION_ACTIVIDADES TEXT                 not null,
   FECHA_INICIO         DATE                 not null,
   FECHA_FIN            DATE                 not null,
   CANTIDAD_HORAS_REALIZADAS INT4                 not null
      constraint CKC_CANTIDAD_HORAS_RE_SOLICITU check (CANTIDAD_HORAS_REALIZADAS >= 0),
   CREDITOS_OTORGADOS   INT4                 null
      constraint CKC_CREDITOS_OTORGADO_SOLICITU check (CREDITOS_OTORGADOS is null or (CREDITOS_OTORGADOS >= 0)),
   constraint PK_SOLICITUD_DE_CREDITOS_ACADE primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_CREDITOS_ACADEMICOS_PK                   */
/*==============================================================*/
create unique index SOLICITUD_DE_CREDITOS_ACADEMICOS_PK on SOLICITUD_DE_CREDITOS_ACADEMICOS (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_DESINSCRIPCION_DE_CURSO                  */
/*==============================================================*/
create table SOLICITUD_DE_DESINSCRIPCION_DE_CURSO (
   SOLICITUD            INT4                 not null,
   MOTIVO_DESINSCRIPCION TEXT                 not null,
   CURSO_COMPLETO_POR_ASIGNATURA BOOL                 not null,
   constraint PK_SOLICITUD_DE_DESINSCRIPCION primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_DESINSCRIPCION_DE_CURSO_PK               */
/*==============================================================*/
create unique index SOLICITUD_DE_DESINSCRIPCION_DE_CURSO_PK on SOLICITUD_DE_DESINSCRIPCION_DE_CURSO (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_EXONERACION                              */
/*==============================================================*/
create table SOLICITUD_DE_EXONERACION (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   CUMPLE_PORCENTAJE_ASISTENCIA CHAR(13)             not null
      constraint CKC_CUMPLE_PORCENTAJE_SOLICITU check (CUMPLE_PORCENTAJE_ASISTENCIA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   AUSENCIA_FINALES     CHAR(13)             not null
      constraint CKC_AUSENCIA_FINALES_SOLICITU check (AUSENCIA_FINALES in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_EXONERACION primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_EXONERACION_PK                           */
/*==============================================================*/
create unique index SOLICITUD_DE_EXONERACION_PK on SOLICITUD_DE_EXONERACION (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_EXTRAORDINARIO                           */
/*==============================================================*/
create table SOLICITUD_DE_EXTRAORDINARIO (
   SOLICITUD            INT4                 not null,
   FECHA_EXTRAORDINARIO DATE                 not null,
   MOTIVO               TEXT                 not null,
   CUMPLE_FECHA         CHAR(13)             not null
      constraint CKC_CUMPLE_FECHA_SOLICITU check (CUMPLE_FECHA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   AUSENTE_TERCERA_OP   CHAR(13)             not null
      constraint CKC_AUSENTE_TERCERA_O_SOLICITU check (AUSENTE_TERCERA_OP in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   INSCRIPTO_TERCERA_OP CHAR(13)             not null
      constraint CKC_INSCRIPTO_TERCERA_SOLICITU check (INSCRIPTO_TERCERA_OP in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_EXTRAORDINARIO primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_EXTRAORDINARIO_PK                        */
/*==============================================================*/
create unique index SOLICITUD_DE_EXTRAORDINARIO_PK on SOLICITUD_DE_EXTRAORDINARIO (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_HOMOLOGACION_DE_MATERIAS                 */
/*==============================================================*/
create table SOLICITUD_DE_HOMOLOGACION_DE_MATERIAS (
   SOLICITUD            INT4                 not null,
   PLAN_DE_ESTUDIO_PREVIO INT4                 not null
      constraint CKC_PLAN_DE_ESTUDIO_P_SOLICITU check (PLAN_DE_ESTUDIO_PREVIO >= 1950),
   PLAN_DE_ESTUDIO_NUEVO INT4                 not null
      constraint CKC_PLAN_DE_ESTUDIO_N_SOLICITU check (PLAN_DE_ESTUDIO_NUEVO >= 1950),
   CARRERA_ANTERIOR     CHAR(80)             not null,
   constraint PK_SOLICITUD_DE_HOMOLOGACION_D primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_HOMOLOGACION_DE_MATERIAS_PK              */
/*==============================================================*/
create unique index SOLICITUD_DE_HOMOLOGACION_DE_MATERIAS_PK on SOLICITUD_DE_HOMOLOGACION_DE_MATERIAS (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_INCLUSION_EN_LISTA                       */
/*==============================================================*/
create table SOLICITUD_DE_INCLUSION_EN_LISTA (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   VALIDEZ_MATERIA      CHAR(13)             not null
      constraint CKC_VALIDEZ_MATERIA_SOLICITU check (VALIDEZ_MATERIA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_INCLUSION_EN_L primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_INCLUSION_EN_LISTA_PK                    */
/*==============================================================*/
create unique index SOLICITUD_DE_INCLUSION_EN_LISTA_PK on SOLICITUD_DE_INCLUSION_EN_LISTA (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_INSCRIPCION_TARDIA_A_EXAMEN              */
/*==============================================================*/
create table SOLICITUD_DE_INSCRIPCION_TARDIA_A_EXAMEN (
   SOLICITUD            INT4                 not null,
   OPORTUNIDAD          INT4                 not null
      constraint CKC_OPORTUNIDAD_SOLICITU check (OPORTUNIDAD between 1 and 3),
   MOTIVO               TEXT                 not null,
   constraint PK_SOLICITUD_DE_INSCRIPCION_TA primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_INSCRIPCION_TARDIA_A_EXAMEN_PK           */
/*==============================================================*/
create unique index SOLICITUD_DE_INSCRIPCION_TARDIA_A_EXAMEN_PK on SOLICITUD_DE_INSCRIPCION_TARDIA_A_EXAMEN (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_PASANTIA                                 */
/*==============================================================*/
create table SOLICITUD_DE_PASANTIA (
   SOLICITUD            INT4                 not null,
   LUGAR                CHAR(80)             not null,
   DIRECCION            VARCHAR(120)         not null,
   TELEFONO             VARCHAR(30)          not null,
   CORREO_ELECTRONICO   CHAR(255)            null,
   MOTIVO               TEXT                 not null,
   constraint PK_SOLICITUD_DE_PASANTIA primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_PASANTIA_PK                              */
/*==============================================================*/
create unique index SOLICITUD_DE_PASANTIA_PK on SOLICITUD_DE_PASANTIA (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_REDUCCION_DE_ASISTENCIA                  */
/*==============================================================*/
create table SOLICITUD_DE_REDUCCION_DE_ASISTENCIA (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   ASISTENCIA_MINIMA    CHAR(13)             not null
      constraint CKC_ASISTENCIA_MINIMA_SOLICITU check (ASISTENCIA_MINIMA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_REDUCCION_DE_A primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_REDUCCION_DE_ASISTENCIA_PK               */
/*==============================================================*/
create unique index SOLICITUD_DE_REDUCCION_DE_ASISTENCIA_PK on SOLICITUD_DE_REDUCCION_DE_ASISTENCIA (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_REVISION_DE_ESCOLARIDAD                  */
/*==============================================================*/
create table SOLICITUD_DE_REVISION_DE_ESCOLARIDAD (
   SOLICITUD            INT4                 not null,
   VALIDEZ_MATERIA      CHAR(13)             not null
      constraint CKC_VALIDEZ_MATERIA_SOLICITU check (VALIDEZ_MATERIA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_REVISION_DE_ES primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_REVISION_DE_ESCOLARIDAD_PK               */
/*==============================================================*/
create unique index SOLICITUD_DE_REVISION_DE_ESCOLARIDAD_PK on SOLICITUD_DE_REVISION_DE_ESCOLARIDAD (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_REVISION_DE_EXAMEN                       */
/*==============================================================*/
create table SOLICITUD_DE_REVISION_DE_EXAMEN (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   FECHA_EXAMEN         DATE                 not null,
   OPORTUNIDAD          INT4                 not null
      constraint CKC_OPORTUNIDAD_SOLICITU check (OPORTUNIDAD between 1 and 3),
   CALIFICACION_PREVIA  INT4                 not null
      constraint CKC_CALIFICACION_PREV_SOLICITU check (CALIFICACION_PREVIA between 0 and 5),
   CALIFICACION_NUEVA   INT4                 not null
      constraint CKC_CALIFICACION_NUEV_SOLICITU check (CALIFICACION_NUEVA between 0 and 5),
   FECHA_HORA_REVISION  DATE                 not null,
   LUGAR_REVISION       CHAR(80)             not null,
   constraint PK_SOLICITUD_DE_REVISION_DE_EX primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_REVISION_DE_EXAMEN_PK                    */
/*==============================================================*/
create unique index SOLICITUD_DE_REVISION_DE_EXAMEN_PK on SOLICITUD_DE_REVISION_DE_EXAMEN (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_RUPTURA_DE_CORRELATIVIDAD                */
/*==============================================================*/
create table SOLICITUD_DE_RUPTURA_DE_CORRELATIVIDAD (
   SOLICITUD            INT4                 not null,
   CUMPLE_PROMEDIO_MINIMO CHAR(13)             not null
      constraint CKC_CUMPLE_PROMEDIO_M_SOLICITU check (CUMPLE_PROMEDIO_MINIMO in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   HASTA_CUARTO_SEMESTRE_REGULAR CHAR(13)             not null
      constraint CKC_HASTA_CUARTO_SEME_SOLICITU check (HASTA_CUARTO_SEMESTRE_REGULAR in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_RUPTURA_DE_COR primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_RUPTURA_DE_CORRELATIVIDAD_PK             */
/*==============================================================*/
create unique index SOLICITUD_DE_RUPTURA_DE_CORRELATIVIDAD_PK on SOLICITUD_DE_RUPTURA_DE_CORRELATIVIDAD (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_TESIS                                    */
/*==============================================================*/
create table SOLICITUD_DE_TESIS (
   SOLICITUD            INT4                 not null,
   TEMA_TESIS           CHAR(80)             not null,
   CUMPLE_APROBACION_MATERIAS CHAR(13)             not null
      constraint CKC_CUMPLE_APROBACION_SOLICITU check (CUMPLE_APROBACION_MATERIAS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_TESIS primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_TESIS_PK                                 */
/*==============================================================*/
create unique index SOLICITUD_DE_TESIS_PK on SOLICITUD_DE_TESIS (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_TITULO                                   */
/*==============================================================*/
create table SOLICITUD_DE_TITULO (
   SOLICITUD            INT4                 not null,
   NOMBRE_TITULO        CHAR(15)             not null
      constraint CKC_NOMBRE_TITULO_SOLICITU check (NOMBRE_TITULO in ('Arquitecto','Ingeniero','Master','Licenciado','Programador','Tecnico','Especializacion','Completo','Incompleto')),
   APROBACION_TOTAL_DE_MATERIAS CHAR(13)             not null
      constraint CKC_APROBACION_TOTAL__SOLICITU check (APROBACION_TOTAL_DE_MATERIAS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   CUMPLE_CREDITOS_REQUERIDOS CHAR(13)             not null
      constraint CKC_CUMPLE_CREDITOS_R_SOLICITU check (CUMPLE_CREDITOS_REQUERIDOS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   PRESENTO_TESIS       CHAR(13)             not null
      constraint CKC_PRESENTO_TESIS_SOLICITU check (PRESENTO_TESIS in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   FOTOCOPIA_CEDULA     BOOL                 not null,
   FOTOCOPIA_CERTIFICADO_NACIMIENTO BOOL                 not null,
   FOTOCOPIA_CERTIFICADO_MATRIMONIO BOOL                 not null,
   FOTOCOPIA_DE_TITULO_DE_GRADO BOOL                 not null,
   FOTOCOPIA_SIMPLE_DE_TITULO BOOL                 not null,
   constraint PK_SOLICITUD_DE_TITULO primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_TITULO_PK                                */
/*==============================================================*/
create unique index SOLICITUD_DE_TITULO_PK on SOLICITUD_DE_TITULO (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_TRASPASO_DE_PAGO_DE_EXAMEN               */
/*==============================================================*/
create table SOLICITUD_DE_TRASPASO_DE_PAGO_DE_EXAMEN (
   SOLICITUD            INT4                 not null,
   OPORTUNIDAD_PAGADA   INT4                 not null
      constraint CKC_OPORTUNIDAD_PAGAD_SOLICITU check (OPORTUNIDAD_PAGADA between 1 and 3),
   OPORTUNIDAD_A_PAGAR  INT4                 not null
      constraint CKC_OPORTUNIDAD_A_PAG_SOLICITU check (OPORTUNIDAD_A_PAGAR between 1 and 3),
   CUMPLE_PLAZO_LIMITE  CHAR(13)             not null
      constraint CKC_CUMPLE_PLAZO_LIMI_SOLICITU check (CUMPLE_PLAZO_LIMITE in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_TRASPASO_DE_PA primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_TRASPASO_DE_PAGO_DE_EXAMEN_PK            */
/*==============================================================*/
create unique index SOLICITUD_DE_TRASPASO_DE_PAGO_DE_EXAMEN_PK on SOLICITUD_DE_TRASPASO_DE_PAGO_DE_EXAMEN (
SOLICITUD
);

/*==============================================================*/
/* Table: SOLICITUD_DE_TUTORIA_DE_CATEDRA                       */
/*==============================================================*/
create table SOLICITUD_DE_TUTORIA_DE_CATEDRA (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   CUMPLE_NOTA_MINIMA_REQUERIDA CHAR(13)             not null
      constraint CKC_CUMPLE_NOTA_MINIM_SOLICITU check (CUMPLE_NOTA_MINIMA_REQUERIDA in ('CUMPLE','NO_CUMPLE','NO_VERIFICADO','FALTANTE')),
   constraint PK_SOLICITUD_DE_TUTORIA_DE_CAT primary key (SOLICITUD)
);

/*==============================================================*/
/* Index: SOLICITUD_DE_TUTORIA_DE_CATEDRA_PK                    */
/*==============================================================*/
create unique index SOLICITUD_DE_TUTORIA_DE_CATEDRA_PK on SOLICITUD_DE_TUTORIA_DE_CATEDRA (
SOLICITUD
);

/*==================================================================*/
/* Table: SOLICITUD_PARA_TOMAR_MATERIA_FUERA_DE_LA_MALLA_CURRICULAR */
/*==================================================================*/
create table SOLICITUD_PARA_TOMAR_MATERIA_FUERA_DE_LA_MALLA_CURRICULAR (
   SOLICITUD            INT4                 not null,
   MOTIVO               TEXT                 not null,
   constraint PK_SOLICITUD_PARA_TOMAR_MATERI primary key (SOLICITUD)
);

/*=====================================================================*/
/* Index: SOLICITUD_PARA_TOMAR_MATERIA_FUERA_DE_LA_MALLA_CURRICULAR_PK */
/*=====================================================================*/
create unique index SOLICITUD_PARA_TOMAR_MATERIA_FUERA_DE_LA_MALLA_CURRICULAR_PK on SOLICITUD_PARA_TOMAR_MATERIA_FUERA_DE_LA_MALLA_CURRICULAR (
SOLICITUD
);

/*==============================================================*/
/* Table: TUTORES_POR_TESIS                                     */
/*==============================================================*/
create table TUTORES_POR_TESIS (
   SOLICITUD            INT4                 not null,
   USUARIO              INT4                 not null,
   constraint PK_TUTORES_POR_TESIS primary key (SOLICITUD, USUARIO)
);

/*==============================================================*/
/* Index: TIENE_TUTORES_PK                                      */
/*==============================================================*/
create unique index TIENE_TUTORES_PK on TUTORES_POR_TESIS (
SOLICITUD,
USUARIO
);

/*==============================================================*/
/* Index: TIENE_TUTORES_FK                                      */
/*==============================================================*/
create  index TIENE_TUTORES_FK on TUTORES_POR_TESIS (
SOLICITUD
);

/*==============================================================*/
/* Index: TIENE_TUTORES_FK2                                     */
/*==============================================================*/
create  index TIENE_TUTORES_FK2 on TUTORES_POR_TESIS (
USUARIO
);

/*==============================================================*/
/* Table: USUARIOS                                              */
/*==============================================================*/
create table USUARIOS (
   USUARIO              SERIAL not null,
   NOMBRES              VARCHAR(80)          not null,
   APELLIDOS            VARCHAR(80)          not null,
   FECHA_NACIMIENTO     DATE                 not null,
   SEXO                 CHAR(1)              not null
      constraint CKC_SEXO_USUARIOS check (SEXO in ('M','F')),
   DIRECCION            VARCHAR(120)         not null,
   TELEFONO             VARCHAR(30)          not null,
   EMAIL                CHAR(255)            null,
   CONTRASENA           VARCHAR(100)         not null,
   ESTADO_CUENTA        CHAR(1)              not null
      constraint CKC_ESTADO_CUENTA_USUARIOS check (ESTADO_CUENTA in ('A','I')),
   constraint PK_USUARIOS primary key (USUARIO)
);

/*==============================================================*/
/* Index: USUARIOS_PK                                           */
/*==============================================================*/
create unique index USUARIOS_PK on USUARIOS (
USUARIO
);

alter table ALUMNOS
   add constraint FK_ALUMNOS_ES_UN_USUARIOS foreign key (USUARIO)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

alter table ALUMNOS_POR_TESIS
   add constraint FK_ALUMNOS__INCLUYE_I_ALUMNOS foreign key (CEDULA)
      references ALUMNOS (CEDULA)
      on delete restrict on update restrict;

alter table ALUMNOS_POR_TESIS
   add constraint FK_ALUMNOS__INCLUYE_I_SOLICITU foreign key (SOLICITUD)
      references SOLICITUD_DE_TESIS (SOLICITUD)
      on delete restrict on update restrict;

alter table ARCHIVOS_ADJUNTOS
   add constraint FK_ARCHIVOS_CONTIENE_CORREOS_ foreign key (CORREO)
      references CORREOS_ELECTRONICOS (CORREO)
      on delete restrict on update restrict;

alter table CORREOS_ELECTRONICOS
   add constraint FK_CORREOS__POSEE_USUARIOS foreign key (USUARIO)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

alter table DOCUMENTOS_ADJUNTOS
   add constraint FK_DOCUMENT_TIENE_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table FECHAS_DE_RESOLUCION_DE_SOLICITUDES
   add constraint FK_FECHAS_D_TIENE_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table HISTORIAL_EXTRAORDINARIOS
   add constraint FK_HISTORIA_TIENE_ALUMNOS foreign key (CEDULA)
      references ALUMNOS (CEDULA)
      on delete restrict on update restrict;

alter table LOGS
   add constraint FK_LOGS_ACCEDE_A_USUARIOS foreign key (USUARIO)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

alter table LOGS
   add constraint FK_LOGS_GENERADO__PARAMETR foreign key (PARAMETRO)
      references PARAMETROS_LOGS (PARAMETRO)
      on delete restrict on update restrict;

alter table PERMISOS_POR_ROL
   add constraint FK_PERMISOS_CONTIENE_PERMISOS foreign key (PERMISO)
      references PERMISOS (PERMISO)
      on delete restrict on update restrict;

alter table PERMISOS_POR_ROL
   add constraint FK_PERMISOS_CONTIENE_ROLES foreign key (ROL)
      references ROLES (ROL)
      on delete restrict on update restrict;

alter table ROLES_POR_USUARIO
   add constraint FK_ROLES_PO_TIENE_ASI_ROLES foreign key (ROL)
      references ROLES (ROL)
      on delete restrict on update restrict;

alter table ROLES_POR_USUARIO
   add constraint FK_ROLES_PO_TIENE_ASI_USUARIOS foreign key (USUARIO)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

alter table SOLICITUDES
   add constraint FK_SOLICITU_HECHA_POR_USUARIOS foreign key (USUARIO_SOLICITANTE)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

alter table SOLICITUDES_POR_FUNCIONARIO
   add constraint FK_SOLICITU_ACCEDEN_A_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUDES_POR_FUNCIONARIO
   add constraint FK_SOLICITU_ACCEDEN_A_USUARIOS foreign key (USUARIO)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

alter table SOLICITUDES_VARIAS
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_CAMBIO_DE_SECCION
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_CERTIFICADO_DE_ESTUDIOS
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_COLABORADOR_DE_CATEDRA
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_CONVALIDACION_DE_MATERIAS
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_CREDITOS_ACADEMICOS
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_DESINSCRIPCION_DE_CURSO
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_EXONERACION
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_EXTRAORDINARIO
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_HOMOLOGACION_DE_MATERIAS
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_INCLUSION_EN_LISTA
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_INSCRIPCION_TARDIA_A_EXAMEN
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_PASANTIA
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_REDUCCION_DE_ASISTENCIA
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_REVISION_DE_ESCOLARIDAD
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_REVISION_DE_EXAMEN
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_RUPTURA_DE_CORRELATIVIDAD
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_TESIS
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_TITULO
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_TRASPASO_DE_PAGO_DE_EXAMEN
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_DE_TUTORIA_DE_CATEDRA
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table SOLICITUD_PARA_TOMAR_MATERIA_FUERA_DE_LA_MALLA_CURRICULAR
   add constraint FK_SOLICITU_ES_UN_SOLICITU foreign key (SOLICITUD)
      references SOLICITUDES (SOLICITUD)
      on delete restrict on update restrict;

alter table TUTORES_POR_TESIS
   add constraint FK_TUTORES__TIENE_TUT_SOLICITU foreign key (SOLICITUD)
      references SOLICITUD_DE_TESIS (SOLICITUD)
      on delete restrict on update restrict;

alter table TUTORES_POR_TESIS
   add constraint FK_TUTORES__TIENE_TUT_USUARIOS foreign key (USUARIO)
      references USUARIOS (USUARIO)
      on delete restrict on update restrict;

