# 📝 To-Do List — Laravel + Vue.js

Este projeto é uma aplicação de lista de tarefas (to-do list) desenvolvida com **Laravel** no backend e **Vue.js** no frontend. Permite ao usuário adicionar, editar, marcar como concluídas e excluir tarefas, com os dados sendo persistidos internamente (mockados).

---

## ✅ Funcionalidades

- Adicionar novas tarefas
- Listar tarefas pendentes e concluídas separadamente
- Editar tarefa
- Marcar tarefas como concluídas
- Excluir tarefas
- Alternar entre modo claro e escuro
- Persistência mockada dos dados

---

## 🧰 Tecnologias Utilizadas

Backend 

- Laravel PHP
- API REST (routes/api.php)
- Middleware CORS para integração com frontend

### Frontend (

- Vue.js com `<script setup>`
- Axios para chamadas HTTP
- Vite como bundler
- Bootstrap 5 para estilização

---

## 🚀 Como Rodar o Projeto

### 1. Clonar o repositório

### 2. Configurar o Backend (Laravel)

```bash
cd laravel
composer install
cp .env.example .env
php artisan key:generate
```

#### Configurar o banco de dados no `.env`

**Exemplo com SQLite:**

```env
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/absoluto/para/database.sqlite
```

> Crie o arquivo SQLite manualmente se necessário:

```bash
touch database/database.sqlite
```

Execute as migrações:

```bash
php artisan migrate
```

Inicie o servidor Laravel:

```bash
php artisan serve
```

O backend estará acessível em `http://localhost:8000`.

---

### 3. Configurar o Frontend (Vue.js)

```bash
cd resources/js
npm install
npm run dev
```

O frontend será servido em `http://localhost:5173` (ou outro informado pelo terminal).

---

### 4. Corrigir CORS (se necessário)

Certifique-se de que o middleware `\Fruitcake\Cors\HandleCors::class` está habilitado no `app/Http/Kernel.php` e que o arquivo `config/cors.php` está configurado para permitir acesso do frontend:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

Reinicie o servidor Laravel se fizer mudanças.

---


## 🔄 Integração

- As tarefas são carregadas via `GET /api/tasks`
- Adição via `POST /api/tasks`
- Edição via `PUT /api/tasks/{id}`
- Exclusão via `DELETE /api/tasks/{id}`
- Toda comunicação é feita por Axios

---
