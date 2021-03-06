# ๐ Game of Thrones - API

<h1 align="center">
    <img alt="Game Of Thrones" src="assets/icon.png" height="128px" />
    <br/>
  <a href="https://nodejs.org/en/" target="_blank" rel="noopener">PHP</a> | <a href="https://www.php.net/docs.php" target="_blank" rel="noopener">Node.js</a>

<p align="center">
  <img alt="Develop by" src="https://img.shields.io/badge/Develop%20by-Gabriel%20Patrola-blue?style=flat&logo=Awesome-Lists">
  <img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/gabrielpatrola/game-of-thrones-api?color=informational&style=flat&logo=GitHub-Actions">
  <img alt="License" src="https://img.shields.io/github/license/gabrielpatrola/game-of-thrones-api?&style=flat&logo=Google-Sheets">
<p>

<h3 align="center">
  <a href="#-about">About</a>
  <span> ยท </span>
  <a href="#-used-stack">Used stack</a>
  <span> ยท </span>
  <a href="#-how-to-use">How to use</a>
  <span> ยท </span>
  <a href="#-license">License</a>
</h3>

## ๐ญ About

A sample script that receives a name as an argument and proceeds to find all information and quotes of this character then insert all data in a database using graphQL.

## ๐จโ๐ป Used stack

- <a href="https://www.php.net/docs.php" target="_blank" rel="noopener">PHP ^8.1</a>
- <a href="https://nodejs.org/en/" target="_blank" rel="noopener">Node</a>

## โ How to use

### ๐ค Requirements

To be able to run this project, first you will need to have in your machine:

### PHP version

- **<a href="https://getcomposer.org" target="_blank" rel="noopener">Composer</a>** to be able to manage the project's dependencies and autoload
- **<a href="https://www.php.net/downloads" target="_blank" rel="noopener">PHP</a>** on version ^8.1
- **<a href="https://git-scm.com/downloads" target="_blank" rel="noopener">Git</a>** to be able to clone this repository

### JS version

- **<a href="https://www.npmjs.com/" target="_blank" rel="noopener">NPM</a>** to manage the project's dependencies
- **<a href="https://git-scm.com/downloads" target="_blank" rel="noopener">Git</a>** to be able to clone this repository

### ๐ Step to Step

### PHP Version
First clone the repository in your computer

1. Cloning the repository

```sh
  # Clone the repository
  $ git clone https://github.com/Gabrielpatrola/game-of-thrones-api.git
  # Go to the project folder
  $ cd game-of-thrones-api/php
```

2. Install the project's dependencies

```sh
  # Installing
  $ composer install
```

3. Run the script

You will need to pass a name as an argument to be able to run this script, you only need to pass the first name of a character from the TV Show, If you pass more than one argument any argument after the first one will be ignored.

```sh
  # passing Jon as an argument for the script
  $ php index.php -n Jon
  # If everything went ok it will show:
  $ 'Character inserted in database'
```

4. Show all data and delete all data

You can pass an argument called `list` to show all stored data and `delete` to remove all data from the database.

```sh
  # Passing the list argument, it will show all sotred data
  $ php index.php -n list
  # Passing the delete, It will remove everything from the database
  $ php index.php -n delete
```

### JS Version

First clone the repository in your computer

1. Cloning the repository

```sh
  # Clone the repository
  $ git clone https://github.com/Gabrielpatrola/game-of-thrones-api.git
  # Go to the project folder
  $ cd game-of-thrones-api/js
```

2. Install the project's dependencies

```sh
  # Installing
  $ npm install
```

3. Run the script

You will need to pass a name as an argument to be able to run this script, you only need to pass the first name of a character from the TV Show, If you pass more than one argument any argument after the first one will be ignored.

```sh
  # passing Jon as an argument for the script
  $ node index.js Jon
  # If everything went ok it will show:
  $ 'Character inserted in database'
```

4. Show all data and delete all data

You can pass an argument called `list` to show all stored data and `delete` to remove all data from the database.

```sh
  # Passing the list argument, it will show all sotred data
  $ node index.js list
  # Passing the delete, It will remove everything from the database
  $ node index.js delete
```

## ๐ License

This project uses the MIT License. See the doc [LICENSE](/LICENSE) for more details.

---

<sup> Made with ๐ by <a href="https://github.com/Gabrielpatrola" target="_blank" rel="noopener">Gabriel "Patrola" Almeida</a>.</sup>
