# 🎉 KWK Events

> *“Organizar é criar ordem onde antes havia caos.”*  
O **KWK Events** nasceu para transformar a experiência de gerenciamento de eventos em algo elegante, rápido e tecnicamente moderno — unindo arquitetura limpa, UX inteligente e tecnologias de ponta.

---

# 📖 Visão Geral

**KWK Events** é uma plataforma full-stack desenvolvida para criação, administração e exibição de eventos com fluidez e precisão.  
Combinando **PHP/Laravel**, **Vue.js com TypeScript**, **TailwindCSS**, **Zod** e **Inertia.js**, o sistema entrega uma experiência rápida, segura e escalável — sem abrir mão de acessibilidade, organização e performance.

Pensado para ser simples na superfície e poderoso internamente, ele oferece uma jornada eficiente para usuários que precisam cadastrar, visualizar ou editar eventos de forma intuitiva.

---

# 🧩 Principais Funcionalidades

| Categoria | Descrição |
| - | - |
| 📅 **Gestão de Eventos** | Criar, editar e listar eventos com datas, locais, categorias e detalhes personalizados. |
| ⚡ **Fluxo Reativo** | Frontend em Vue 3 + TypeScript, com experiência instantânea via Inertia.js. |
| 🎨 **Interface Responsiva** | UI moderna com TailwindCSS, acessível e consistente. |
| 🛡️ **Validação Avançada** | Zod garantindo segurança e consistência no fluxo de dados. |
| 🧠 **Estado Inteligente** | Zustand para gerenciamento de estado simples e poderoso. |
| 🔍 **Busca e Filtros** | Filtragem por nome, data, categoria e status. |
| 🚀 **Arquitetura Moderna** | Backend sólido em Laravel e frontend tipado com Vue + TS. |

---

# ⚙️ Tecnologias Utilizadas

| Stack | Ferramentas |
| - | - |
| **Backend** | PHP · Laravel · Eloquent ORM |
| **Frontend** | Vue.js · TypeScript · Inertia.js |
| **Estilo** | TailwindCSS |
| **Validação** | Zod |
| **Estado** | Zustand |
| **DevTools** | Vite · ESLint · Prettier |

---

# 🏗️ Arquitetura do Projeto

<pre>
kwk-events/
├── app/                   → Backend Laravel
├── public/                → Assets públicos
├── resources/
│   ├── js/
│   │   ├── pages/         → Páginas Vue + Inertia.js
│   │   ├── components/    → Componentes reutilizáveis
│   │   ├── store/         → Zustand Store
│   │   └── types/         → Tipos TypeScript compartilhados
│   └── views/             → Templates blade
├── routes/                → Rotas web e API
└── database/
    ├── migrations/        → Estrutura do banco
    └── seeders/           → Dados iniciais
</pre>

---

# 💻 Instalação e Execução

# Instalar dependências Laravel
<pre>
composer install
</pre>

# Instalar dependências do frontend
<pre>
npm install
# ou
bun install
</pre>

# Rodar ambiente local
<pre>
php artisan serve
npm run dev
</pre>

---

# 🔍 Boas Práticas Implementadas

- Separação clara entre UI, lógica e dados  
- Tipagem completa com TypeScript e Zod  
- Arquitetura escalável e modular  
- Acessibilidade (ARIA, navegação por teclado, contraste)  
- Componentes reutilizáveis e padronizados  
- Padrões de commits e linting  
- Vite para build rápido e DX premium  

---

# 🧪 Testes

- Testes de fluxo de criação e edição de eventos  
- Testes de componentes Vue  
- Mock de estado com Zustand  
- Verificação de rotas e interações principais  

---

# 📜 Licença

Projeto de uso aberto para estudo e colaboração, respeitando a autoria de **Joseph Kawe (KWK Technologies)**.

---

# 🧩 Resumo

**KWK Events** combina organização, design e engenharia moderna para entregar uma experiência completa de gerenciamento de eventos.  
Simples, bonito e poderoso — como todo software deveria ser.
