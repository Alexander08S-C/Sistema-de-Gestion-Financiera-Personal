# 💰 Sistema de Gestión Financiera Personal

Sistema web completo para el control de finanzas personales desarrollado con Laravel y Vue.js. Permite gestionar cuentas bancarias, registrar ingresos y gastos, visualizar estadísticas financieras en tiempo real mediante gráficos interactivos.

<img width="1852" height="912" alt="image" src="https://github.com/user-attachments/assets/27e865e6-d767-4f73-b727-1fdc5fb83111" />
<img width="1854" height="510" alt="image" src="https://github.com/user-attachments/assets/10497c65-02cc-468b-b621-340210bf714a" />
<img width="1865" height="844" alt="image" src="https://github.com/user-attachments/assets/bc241fad-8fb6-4178-958b-0e7250138967" />
<img width="1857" height="883" alt="image" src="https://github.com/user-attachments/assets/7e84abc4-240f-453f-8c0d-6b63c84914e5" />



## 🚀 Características Principales

### 📊 Dashboard Interactivo
- Visualización en tiempo real del balance total
- Resumen de ingresos y gastos mensuales
- Gráficos interactivos:
  - Pie chart de gastos por categoría
  - Gráfico de líneas con tendencia de ingresos vs gastos
- Lista de transacciones recientes

### 💳 Gestión de Cuentas
- Crear múltiples cuentas bancarias
- Soporte para diferentes tipos: ahorros, corriente, tarjeta de crédito, efectivo
- Múltiples monedas (PEN, USD, EUR)
- Colores personalizables para cada cuenta
- Balance automático actualizado

### 💸 Gestión de Transacciones
- Registro de ingresos y gastos
- Categorización automática con íconos
- Filtrado por tipo (ingreso/gasto)
- Edición y eliminación de transacciones
- Actualización automática de balance
- Tabla completa con paginación

### 🎨 Interfaz de Usuario
- Diseño moderno y responsive
- Experiencia de usuario fluida con Inertia.js
- Formularios intuitivos con validación en tiempo real
- Feedback visual inmediato

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 12.51** - Framework PHP
- **MySQL** - Base de datos relacional
- **Inertia.js** - Comunicación frontend-backend sin API REST

### Frontend
- **Vue.js 3** - Framework JavaScript (Composition API)
- **Tailwind CSS** - Framework de estilos
- **Chart.js + vue-chartjs** - Visualización de datos
- **Vite** - Build tool y bundler

### Herramientas
- **Composer** - Gestor de dependencias PHP
- **NPM** - Gestor de dependencias JavaScript

## 📦 Instalación

### Requisitos Previos
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL
- Git

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/tuusuario/finance-dashboard.git
cd finance-dashboard
```

2. **Instalar dependencias de PHP**
```bash
composer install
```

3. **Instalar dependencias de JavaScript**
```bash
npm install --legacy-peer-deps
```

4. **Configurar el archivo de entorno**
```bash
cp .env.example .env
```

5. **Generar la clave de aplicación**
```bash
php artisan key:generate
```

6. **Configurar la base de datos**

Edita el archivo `.env` y configura tu conexión a MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finance_dashboard
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

7. **Crear la base de datos**

Crea una base de datos llamada `finance_dashboard` en MySQL/phpMyAdmin.

8. **Ejecutar las migraciones y seeders**
```bash
php artisan migrate
php artisan db:seed --class=CategorySeeder
```

9. **Compilar los assets del frontend**
```bash
npm run dev
```

10. **Iniciar el servidor**

Abre una nueva terminal y ejecuta:
```bash
php artisan serve
```

11. **Acceder a la aplicación**

Abre tu navegador en: `http://localhost:8000`

## 📸 Capturas de Pantalla

### Dashboard Principal
Vista general con estadísticas y gráficos interactivos

### Gestión de Transacciones
Tabla completa con todas las transacciones y opciones de edición

### Formularios
Interfaces intuitivas para crear cuentas y transacciones

## 🗂️ Estructura del Proyecto
```
finance-dashboard/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/               # Modelos Eloquent
│   └── Services/             # Servicios y lógica de negocio
├── database/
│   ├── migrations/           # Migraciones de base de datos
│   └── seeders/              # Seeders de datos iniciales
├── resources/
│   ├── js/
│   │   ├── Components/       # Componentes Vue reutilizables
│   │   ├── Layouts/          # Layouts de la aplicación
│   │   └── Pages/            # Páginas Vue (Inertia)
│   └── css/                  # Estilos
├── routes/
│   └── web.php               # Rutas de la aplicación
└── public/                   # Assets públicos
```

## 🎯 Funcionalidades Futuras

- [ ] Integración con IA para análisis financiero avanzado
- [ ] Sistema de presupuestos con alertas
- [ ] Exportación de reportes en PDF
- [ ] Gráficos adicionales (balance histórico, comparativas)
- [ ] Filtros avanzados de búsqueda
- [ ] Categorías personalizadas por usuario
- [ ] Modo oscuro

## 👨‍💻 Autor

**Alexander**
- GitHub:  https://github.com/Alexander08S-C
- LinkedIn: https://linkedin.com/in/alexander-jesus-sanchez-clemente-934164327/
- Email: alexander08s.c@hotmail.com

## 📝 Licencia

Este proyecto fue desarrollado como parte de un portafolio personal.

## 🙏 Agradecimientos

Proyecto desarrollado para demostrar habilidades en:
- Desarrollo Full-Stack con Laravel y Vue.js
- Gestión de bases de datos relacionales
- Creación de interfaces de usuario modernas
- Implementación de gráficos interactivos
- Arquitectura MVC y buenas prácticas de código

---

⭐ Si te gusta este proyecto, ¡dale una estrella en GitHub!
