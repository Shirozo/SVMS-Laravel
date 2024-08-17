# Student Voting System

## About Student Voting System

The Student Voting System is a secure, user-friendly web application designed to facilitate efficient elections. Built with the robust Laravel framework, this system allows students to participate in elections, nominate candidates, and cast their votes with ease.


## Dependecies Installation

Before you can run or deploy this project, we first need to install all the dependencies below:

- **Git**
    - **For Windows**<br>
    Go to [Installation](https://git-scm.com/download/win) and select 64bit.

    - **For Linux Run**<br>
    `sudo apt install git-all`

- **PHP 8.3 or higher**
    - **For Windows**<br>
    **Go to [Installation](https://www.php.net/downloads.php). And install all libary used in linux below**
    - **For Linux Run**<br>
    `sudo apt install openssl php8.3 php8.3-bcmath php8.3-curl php8.3-json php8.3-mbstring php8.3-mysql php8.3-tokenizer php8.3-xml php8.3-zip`
- **Composer**
    - **For Windows**<br>
    Follow this [instruction](https://getcomposer.org/doc/00-intro.md#installation-windows).
    - **For Linux**<br>
    Follow this [instruction](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).
- **Node**
    - **For Windows**<br>
    Follow this [instruction](https://nodejs.org/en/download/package-manager) and select windows.
    - **For Linux Run**<br>
    `sudo apt install node`

- **DBMS**
    - You can use any DBMS like mariadb, mysql, or postgreSQL.


## Running

#### If all dependencies are meet run the command below

1. Open your terminal with the desired directory and clone the repository. <br>
Run: `git clone https://github.com/Shirozo/SVMS-Laravel.git` <br>
**Supply your username and password** <br>
Go to this [link](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens#creating-a-personal-access-token-classic) to create personal access token as your password.

2. Go to project directory <br>
Run: `cd SVMS-Laravel`

3. Download all package <br>
Run: `composer install` <br>
Run: `npm install`

4. Creating database connection <br>
    - Create a `.env` file and copy all the content in the `.env.example` to `.env`. <br>
    - Change this line to your database development configuration. <br>
    Here's the sample: <br>
    `DB_CONNECTION=mariadb` <br>
    `DB_HOST=127.0.0.1` <br>
    `DB_PORT=3306` <br>
    `DB_DATABASE=laravel_VMS` <br>
    `DB_USERNAME=laravel` <br>
    `DB_PASSWORD=laravel` <br>

5. Migrating database table. <br>
After configuring the database, run `php artisan migrate`.

6. Creating admin <br>
Run: `php artisan admin:create`

7. Serving the web locally. <br>
You need **3 terminal session**. For `server`, `node`, and `queue job`. <br>
Run: `php artisan serve` <br>
Run: `php artisan queue:work` <br>
Run: `npm run dev` <br>

8. Accessing. <br>
Go to: `localhost:8000`

## Security Vulnerabilities

If you discover a security vulnerability, please open an issue ticket.

## License

The Student Voting System is closed-source for now since it is under development. But, will be open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
