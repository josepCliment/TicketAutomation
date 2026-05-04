# 🎯 Guía Rápida - Categorías y Tiendas

## Acceder Rápidamente

### Desde el navegador
1. **Categorías**: `http://localhost/categories`
2. **Tiendas**: `http://localhost/stores`

### O desde el menú
- Haz clic en **"Settings ▼"** en la barra de navegación
- Selecciona **"Categories"** o **"Stores"**

---

## ➕ Crear una Categoría

1. Ve a `/categories/create`
2. Ingresa un nombre (ej: "Plomería")
3. El slug se genera automáticamente
4. Haz clic en **"Create Category"**

### Ejemplo:
```
Nombre: Plomería
Slug: (auto-generado) → plomeria
```

---

## ➕ Crear una Tienda

1. Ve a `/stores/create`
2. Rellena los campos:
   - **Nombre**: ej "Home Center"
   - **Palabras clave**: ej "homecenter, home center, hc" (separadas por comas)
   - **Estado**: ✓ Active (por defecto)
3. Haz clic en **"Create Store"**

### Ejemplo:
```
Nombre: Home Center
Keywords: homecenter, home center, hc
Status: Active ✓
```

---

## 📝 Editar

### Categoría
1. Ve a **Categorías** (`/categories`)
2. Encuentra la categoría en la tabla
3. Haz clic en **"Edit"**
4. Modifica el nombre
5. Haz clic en **"Save Changes"**

### Tienda
1. Ve a **Tiendas** (`/stores`)
2. Encuentra la tienda en la tabla
3. Haz clic en **"Edit"**
4. Modifica nombre, keywords o estado
5. Haz clic en **"Save Changes"**

---

## 🗑️ Eliminar

### Categoría
1. Ve a **Categorías** (`/categories`)
2. En la tabla, busca el botón **"Delete"** (en rojo)
3. Confirma la eliminación
4. ✓ Eliminada

### Tienda
1. Ve a **Tiendas** (`/stores`)
2. En la tabla, busca el botón **"Delete"** (en rojo)
3. Confirma la eliminación
4. ✓ Eliminada

---

## 📋 Listar

### Categorías
- Accede a `/categories`
- Verás tabla con:
  - Nombre
  - Slug
  - Acciones (Edit, Delete)
- Paginación: 10 por página

### Tiendas
- Accede a `/stores`
- Verás tabla con:
  - Nombre
  - Palabras clave (badges azules)
  - Estado (Active/Inactive)
  - Acciones (Edit, Delete)
- Paginación: 10 por página

---

## 🔄 Palabras Clave en Tiendas

Las palabras clave se usan para **auto-detectar** la tienda cuando procesas tickets.

### Ejemplo:
**Tienda:** Obramat
**Keywords:**
- obramat
- obramat.com.ar

Cuando un receipt tenga "OBRAMAT" en el texto, se auto-detectará la tienda.

---

## 🔐 Permisos

- ✅ Solo usuarios autenticados pueden ver estas páginas
- ✅ Si no está logueado, será redirigido a `/login`
- ✅ Usuario de prueba: `admin@example.com` / `password`

---

## ⚠️ Validaciones

### Categorías
- ✅ Nombre obligatorio
- ✅ Nombre único (no puede repetirse)
- ✅ Máximo 100 caracteres

### Tiendas
- ✅ Nombre obligatorio
- ✅ Nombre único
- ✅ Palabras clave obligatorias
- ✅ Máximo 100 caracteres en nombre

---

## 💡 Tips

1. **Nombres descriptivos**: Usa nombres claros (ej "Tejado" en vez de "T")
2. **Palabras clave útiles**: Incluye variaciones (ej "home depot", "homedepot", "hd")
3. **Minúsculas**: Las palabras clave funcionan en minúsculas (no importa cómo estén en el receipt)
4. **Sin espacios extra**: Recorta espacios al ingresar palabras clave

---

## 🎨 Estados de Tienda

### ✓ Active
- Se usa para auto-detección
- Aparece en selectores
- Usada en párrafos de procesamiento

### ○ Inactive
- No se usa para auto-detección
- No aparece en selectores
- Útil para tiendas obsoletas

---

## 📞 Necesitas Ayuda?

Consulta:
- 📖 `CATEGORIES_STORES_GUIDE.md` - Guía detallada
- 🔐 `LOGIN_GUIDE.md` - Info de autenticación
- 📋 `IMPLEMENTATION_SUMMARY.md` - Resumen técnico

---

**¡Todo listo para gestionar tus categorías y tiendas!** 🚀

