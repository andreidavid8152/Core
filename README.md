# Plataforma de Recetas Personalizadas - NutriCore

## Descripción del Proyecto
El presente proyecto se enfoca en la nutrición y la creación de recetas personalizadas. La plataforma permite a los usuarios subir recetas, mientras que otros usuarios pueden marcarlas como favoritas si les resultan útiles. La aplicación utiliza datos de preferencias alimenticias, restricciones dietéticas y características personales para recomendar recetas que han funcionado para otros usuarios con perfiles similares. Por otro lado el administrador se encargara de cargar las restricciones, preferencias e ingredientes que existiran dentro de la aplicacion.

## Cómo Instalar y Ejecutar el Proyecto
1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/andrei-flores/proyecto-recetas-personalizadas.git
   ```
2. **Instalar dependencias:**
   ```bash
   composer install
   npm install
   ```
3. **Configurar variables de entorno:** Editar el archivo `.env` con las credenciales necesarias (base de datos, claves API, etc.).
4. **Migrar la base de datos:**
   ```bash
   php artisan migrate
   ```
5. **Levantar el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```

## Cómo Utilizar el Proyecto
1. **Creación de Recetas:** Los usuarios pueden acceder al formulario de creación de recetas para ingresar los ingredientes, pasos de preparación y calorías.
2. **Marcar Favoritos:** Los usuarios pueden navegar por las recetas y marcarlas como favoritas para facilitar su acceso posterior.
3. **Ver Recomendaciones:** La aplicación sugerirá recetas basadas en las preferencias del usuario y las experiencias de otros usuarios con características similares.
4. **Gestión de Ingredientes (Administrador):** El administrador puede gestionar los ingredientes, permitiendo crear, editar y eliminar ingredientes.
   - **Restricción de eliminación:** No se permite eliminar un ingrediente si está en uso en alguna receta; en tal caso, el sistema muestra una advertencia.
5. **Gestión de Restricciones Alimenticias (Administrador):** El administrador puede crear, editar y eliminar restricciones que se asignan a los usuarios. Esto permite adaptar las recomendaciones de recetas según las necesidades dietéticas de cada usuario.
   - **Restricción de eliminación:** No se puede eliminar una restricción en uso por algún usuario. El sistema evitará la eliminación y mostrará un mensaje de advertencia.
6. **Gestión de Preferencias (Administrador):** El administrador puede crear, editar y eliminar preferencias que se asignan a los usuarios, permitiendo que se personalicen aún más las recomendaciones de recetas según los gustos individuales.
   - **Restricción de eliminación:** No se puede eliminar una preferencia en uso; si está asociada a algún usuario, se mostrará un mensaje de advertencia.

## Créditos
- **Videos de referencia:**
  - [Fazt Code - Laravel desde cero (Parte 1)](https://www.youtube.com/watch?v=_Rsen6614Dg&t=247s&ab_channel=FaztCode)
  - [Fazt Code - Laravel desde cero (Parte 2)](https://www.youtube.com/watch?v=uU7tWbyqKXc&t=494s&ab_channel=FaztCode)

## Licencia
Este proyecto se distribuye bajo la Licencia MIT. Puedes usarlo, modificarlo y distribuirlo libremente.