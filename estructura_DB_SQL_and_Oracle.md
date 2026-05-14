# Estructura de Base de Datos (Estandarizada para SQL y Oracle)

Este documento define la estructura de datos para la Aplicación de Bienestar, optimizada para compatibilidad con Laravel (MySQL/PostgreSQL) y futuras migraciones a Oracle Database.

---

### 1. Tabla: `usuarios`

Datos base de todas las personas en el sistema.

- `id`: **NUMBER / BigInt** (Primary Key)
- `nombre_apellido`: **VARCHAR2(255)**
- `identificacion`: **NUMBER / BigInt** (Unique)
- `correo`: **VARCHAR2(255)** (Unique)
- `password`: **VARCHAR2(255)**
- `telefono`: **VARCHAR2(20)**
- `genero`: **VARCHAR2(20)** (Enum en App / Check Constraint en Oracle)
- `etnia`: **VARCHAR2(50)** (Enum en App / Check Constraint en Oracle)
- `discapacidad`: **VARCHAR2(255)** (Null allowed)

### 2. Tabla: `administrativos`

Perfil específico para personal administrativo.z

- `id`: **NUMBER / BigInt** (Primary Key)
- `usuario_id`: **NUMBER / BigInt** (Foreign Key -> usuarios.id)
- `area`: **VARCHAR2(100)** (Enum en App)
- `rol`: **VARCHAR2(100)** (Enum en App)

### 3. Tabla: `estudiantes`

Perfil específico para estudiantes.

- `id`: **NUMBER / BigInt** (Primary Key)
- `usuario_id`: **NUMBER / BigInt** (Foreign Key -> usuarios.id)
- `facultad`: **VARCHAR2(100)** (Enum en App)
- `nombre_carrera`: **VARCHAR2(100)** (Enum en App)
- `semestre`: **NUMBER(2)**

### 4. Tabla: `terceros`

Perfil para usuarios externos o invitados.

- `id`: **NUMBER / BigInt** (Primary Key)
- `usuario_id`: **NUMBER / BigInt** (Foreign Key -> usuarios.id)
- `estamento`: **VARCHAR2(100)** (Enum en App)

### 5. Tabla: `cursos`

Catálogo general de cursos de bienestar.

- `id`: **NUMBER / BigInt** (Primary Key)
- `codigo`: **VARCHAR2(20)** (Unique - Ej: "DEP-001")
- `nombre`: **VARCHAR2(255)**
- `tipo_curso`: **VARCHAR2(50)** (Deportivo, Cultural, etc.)
- `descripcion`: **VARCHAR2(4000)** (Equivalente a Text)
- `imagen`: **VARCHAR2(255)** (Path de la imagen)
- `activo`: **NUMBER(1)** (Default 1 - Boolean simulado para Oracle)

### 6. Tabla: `horarios`

Instancias específicas (grupos) de cada curso.

- `id`: **NUMBER / BigInt** (Primary Key)
- `curso_id`: **NUMBER / BigInt** (Foreign Key -> cursos.id)
- `dia`: **VARCHAR2(15)** (Lunes, Martes, etc.)
- `hora_inicio`: **VARCHAR2(5)** (Formato HH:MM)
- `hora_fin`: **VARCHAR2(5)** (Formato HH:MM)
- `profesor`: **VARCHAR2(255)**
- `salon`: **VARCHAR2(100)**
- `cupo_maximo_estudiante`: **NUMBER(4)**
- `cupo_disponible_estudiante`: **NUMBER(4)**
- `cupo_maximo_tercero`: **NUMBER(4)**
- `cupo_disponible_tercero`: **NUMBER(4)**
- `activo`: **NUMBER(1)** (Default 1)

### 7. Tabla: `inscripciones`

Registro de usuarios anotados en horarios.

- `id`: **NUMBER / BigInt** (Primary Key)
- `usuario_id`: **NUMBER / BigInt** (Foreign Key -> usuarios.id)
- `horario_id`: **NUMBER / BigInt** (Foreign Key -> horarios.id)
- `fecha_inscripcion`: **TIMESTAMP / DateTime**
- `tipo_inscripcion`: **VARCHAR2(50)** (Estudiante, Tercero, etc.)

---

## Equivalencias de Tipos para Migración

| Tipo Conceptual | MySQL / PostgreSQL | Oracle Database           |
| :-------------- | :----------------- | :------------------------ |
| Integer (ID)    | `BIGINT`           | `NUMBER(19,0)`            |
| String          | `VARCHAR(255)`     | `VARCHAR2(255)`           |
| Boolean         | `BOOLEAN`          | `NUMBER(1)` (0 o 1)       |
| Text            | `TEXT`             | `VARCHAR2(4000)` o `CLOB` |
| DateTime        | `DATETIME`         | `TIMESTAMP`               |
