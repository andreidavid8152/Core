# Plataforma de Recetas Personalizadas - NutriCore

## Descripción del Proyecto
El presente proyecto se enfoca en la nutrición y la creación de recetas personalizadas. La plataforma permite a los usuarios subir recetas, mientras que otros usuarios pueden marcarlas como favoritas si les resultan útiles. La aplicación utiliza datos de preferencias alimenticias, restricciones dietéticas y características personales para recomendar recetas que han funcionado para otros usuarios con perfiles similares.

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

## Créditos
- **Videos de referencia:**
  - [Fazt Code - Laravel desde cero (Parte 1)](https://www.youtube.com/watch?v=_Rsen6614Dg&t=247s&ab_channel=FaztCode)
  - [Fazt Code - Laravel desde cero (Parte 2)](https://www.youtube.com/watch?v=uU7tWbyqKXc&t=494s&ab_channel=FaztCode)

## Licencia
Este proyecto se distribuye bajo la Licencia MIT. Puedes usarlo, modificarlo y distribuirlo libremente.