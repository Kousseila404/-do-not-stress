# 🧠 Do Not Stress

> DNS privé automatisé sous Bind9, avec scripts Bash et interface PHP

---

## 🎯 Objectif

Créer un serveur **DNS privé sous Debian** permettant aux **étudiants et professeurs** de l’école de **créer leurs propres zones DNS** et **héberger leur site web localement** sur la connexion du campus.

L’ensemble du système est **automatisé avec des scripts Bash** et accompagné d’une **interface PHP** pour gérer facilement les entrées sans passer par la ligne de commande.

---

## ⚙️ Stack technique

- **Bind9** — Service DNS principal  
- **Bash** — Automatisation des fichiers de zones et des tâches récurrentes  
- **PHP** — Interface utilisateur pour la gestion des domaines  
- **Apache2** — Serveur web  
- **Debian 12** — Environnement système

---

## 💡 Fonctionnalités principales

- ✅ Création / suppression automatique de zones DNS  
- ✅ Mise à jour dynamique des enregistrements (A, CNAME, MX, etc.)  
- ✅ Interface PHP intuitive accessible via le réseau de l’école  
- ✅ Sauvegarde automatique et validation des fichiers avant rechargement  
- ✅ Documentation claire pour l’exploitation et la maintenance  

---

## 🧩 Structure du projet

/Do-Not-Stress
│
├── css/
│   ├── admin.css
│   ├── aide.css
│   ├── enregistrements.css
│   ├── index.css
│   ├── inscription.css
│   ├── lstban.css
│   ├── profil.css
│
├── img/
│   ├── tt.jpg
│
├── script/
│   ├── create_zone.sh
│   ├── create_enr.sh
│   ├── suppr_enr.sh
│   ├── suzone.sh
│
├── source/
│   ├── admin.php
│   ├── aide.php
│   ├── ban.php
│   ├── config.php
│   ├── deco.php
│   ├── deban.php
│   ├── dlacc.php
│   ├── enregistrements.php
│   ├── index.php
│   ├── inscription.php
│   ├── lstban.php
│   ├── profil.php
│
├── .gitattributes
└── README.md
---

## 🧠 Ce que j’ai appris

- Déployer un service réseau **comme en production**  
- Automatiser tout en gardant la **fiabilité et la sécurité**  
- **Documenter** pour une exploitation claire et durable  
- Créer une **interface utilisateur intuitive** pour un vrai usage collectif  
- Gérer la **collaboration multi-utilisateurs** (professeurs, étudiants) sur un même service réseau  

---

## 🚀 Auteur

**Kousseila AZNI**  
🔗 [LinkedIn](https://www.linkedin.com/in/kousseila-azni) | [Portfolio WebCatalyste](https://webcatalyste.fr)
