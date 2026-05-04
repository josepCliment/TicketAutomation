# Gestión de Categorías y Tiendas - Guía de Uso

## ✅ Implementación Completada

Se ha añadido funcionalidad **CRUD completa** (Crear, Leer, Actualizar, Eliminar) para Categorías y Tiendas.

---

## 📂 Estructura de Archivos

### Controladores
- `app/Http/Controllers/CategoryController.php` - Gestión de categorías
- `app/Http/Controllers/StoreController.php` - Gestión de tiendas

### Vistas
```
resources/views/
├── categories/
│   ├── index.blade.php    (Listado)
│   ├── create.blade.php   (Crear)
│   └── edit.blade.php     (Editar)
└── stores/
    ├── index.blade.php    (Listado)
    ├── create.blade.php   (Crear)
    └── edit.blade.php     (Editar)
```

### Rutas Registradas

#### Categorías
```
GET     /categories              → categories.index      (Listado)
GET     /categories/create       → categories.create     (Formulario crear)
POST    /categories              → categories.store      (Guardar)
GET     /categories/{id}/edit    → categories.edit       (Formulario editar)
PATCH   /categories/{id}         → categories.update     (Actualizar)
DELETE  /categories/{id}         → categories.destroy    (Eliminar)
```

#### Tiendas
```
GET     /stores                  → stores.index         (Listado)
GET     /stores/create           → stores.create        (Formulario crear)
POST    /stores                  → stores.store         (Guardar)
GET     /stores/{id}/edit        → stores.edit          (Formulario editar)
PATCH   /stores/{id}             → stores.update        (Actualizar)
DELETE  /stores/{id}             → stores.destroy       (Eliminar)
```

---

## 🎯 Cómo Usar

### Acceso desde la Navegación

1. **Opción 1:** Menú "Settings" en la navegación
   - Haz clic en "Settings ▼" en la barra superior
   - Selecciona "Categories" o "Stores"

2. **Opción 2:** URLs directas
   - Categorías: `/categories`
   - Tiendas: `/stores`

### Gestionar Categorías

#### Listar
- URL: `/categories`
- Ver todas las categorías con nombre y slug

#### Crear
- URL: `/categories/create`
- Campos:
  - **Nombre** (requerido, único)
  - El slug se genera automáticamente

#### Editar
- URL: `/categories/{id}/edit`
- Actualizar nombre (se regenera el slug)

#### Eliminar
- Desde la lista, haz clic en "Delete"
- Confirmación requerida

### Gestionar Tiendas

#### Listar
- URL: `/stores`
- Ver tiendas con palabras clave y estado (Activa/Inactiva)

#### Crear
- URL: `/stores/create`
- Campos:
  - **Nombre** (requerido, único)
  - **Palabras Clave** (requerido)
    - Separadas por comas
    - Usadas para auto-detectar tiendas en recibos
  - **Estado** (Activa por defecto)

#### Editar
- URL: `/stores/{id}/edit`
- Cambiar nombre, palabras clave, estado

#### Eliminar
- Desde la lista, haz clic en "Delete"
- Confirmación requerida

---

## 🔒 Seguridad

✅ **Autenticación**: Solo usuarios logueados pueden acceder
✅ **CSRF Protection**: Todos los formularios tienen token CSRF
✅ **Validación**: 
- Nombres únicos
- Palabras clave no vacías
- Campos requeridos
✅ **Confirmación**: Diálogo de confirmación antes de eliminar

---

## 🗂️ Modelos

### Category
```php
protected $fillable = ['name', 'slug'];
```

### Store
```php
protected $fillable = ['name', 'slug', 'match_keywords', 'active'];

protected $casts = [
    'match_keywords' => 'array',
    'active'         => 'bool',
];
```

---

## 📝 Ejemplos

### Crear una Categoría

1. Ir a `/categories/create`
2. Ingresar: "Electricidad"
3. Hacer clic en "Create Category"
4. Se crea con slug: "electricidad"

### Crear una Tienda

1. Ir a `/stores/create`
2. Campos:
   - **Name**: "Home Depot"
   - **Keywords**: "home depot, homedepot.com, depot"
   - **Active**: ✓ Checked
3. Hacer clic en "Create Store"
4. Tienda disponible para auto-detección

---

## 💡 Características Principales

### Categorías
- ✅ CRUD completo
- ✅ Slug generado automáticamente
- ✅ Paginación (10 por página)
- ✅ Mensajes de confirmación

### Tiendas
- ✅ CRUD completo
- ✅ Palabras clave para auto-detección
- ✅ Estado activo/inactivo
- ✅ Slug generado automáticamente
- ✅ Paginación (10 por página)

---

## 🔄 Integración con Sistema

### Categorías
Las categorías se usan en:
- Formulario de upload de tickets (`/tickets/create`)
- Edición de tickets (`/tickets/{id}/edit`)
- Vista de detalles de ticket

### Tiendas
Las tiendas se usan en:
- Auto-detección de tienda en formularios
- Matching de palabras clave en recibos
- Procesamiento automático de tickets

---

## 📊 Gestión de Datos

### Paginación
- Ambos listados (categorías y tiendas) muestran 10 items por página
- Enlaces de navegación en la parte inferior

### Búsqueda/Filtrado
- No hay búsqueda integrada (puede agregarse en el futuro)
- Actualmente se muestran todos los items

### Validaciones
```php
// Categorías
'name' => ['required', 'string', 'max:100', 'unique:categories,name']

// Tiendas
'name' => ['required', 'string', 'max:100', 'unique:stores,name']
'match_keywords' => ['required', 'string']
'active' => ['boolean']
```

---

## 🚀 Próximas Mejoras (Opcionales)

1. **Búsqueda**: Agregar filtro de búsqueda en listados
2. **Bulk Actions**: Seleccionar múltiples items para eliminar
3. **Importar/Exportar**: CSV para categorías y tiendas
4. **Auditoría**: Registrar cambios (quién, cuándo, qué)
5. **Asociaciones**: Ver tickets por categoría/tienda

---

**Status**: ✅ **Completado y funcional**

**Última actualización**: 4 de Mayo de 2026

