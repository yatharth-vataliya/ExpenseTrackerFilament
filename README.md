# This Project is for learning purpose with feature that we can use for maintaining daily expenses. For now I maintain this application as long as I am using it.

## Setup steps

### First you have to make sure that your system meets minimum requirements to run this project and following are required tools (this instruction guide is intented for Debian/Ubuntu user only).

> ***Prerequirements***
>
> - PHP 8.3 or latest
> - composer (PHP package manager)
> - Bun (A JavaScript Runtime)
> - MySql Database
> - Git (for cloning repo to local machine)

### You can download everything manually or use my script for download everything easily

- Copy this [install.sh](https://github.com/yatharth-vataliya/linux-scripts/blob/master/install.sh) file locally and run below mentioned command in bash shell.

```bash
bash install.sh
```
- It will as ask you for input about what you want to install.
- You can do that multiple time for installing multiple tools.

> ### Above install script is only for (Debian/Ubuntu) if you are on Windows or Mac then you can use [herd](https://herd.laravel.com) which is Laravel first Party UI Software that manages all the stuff like PHP and it's versions, DB, NodeJs, and many more.

- After downloading all required tools you can just clone this repo using below mentioned command.

```bash
git clone https://github.com/yatharth-vataliya/ExpenseTracker.git
```

- Now go into the repository directory.
- Then rename .env.example file to .env

```bash
cp .env.example .env
```

- After that setup database credentials and necessary values in .env file

- Then just run below mentioned command to install necessary PHP and JS libraries.

```bash
bash ci.sh
php artisan key:generate
```

- For running scheduling commands please make change in your cron file using `crontab -e` in you terminal then paste following line at the end of crontab file

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

- Now you can start this project by following command `php artisan serve`

- Now you will get a URL in terminal where this project is deployed (mostly it will be [http://localhost:8000/](http://localhost:8000/)).

## Security Vulnerabilities

If you discover a security vulnerability within any part of this application, please send an e-mail to Yatharth Vataliya via [yatharthvataliya@gmail.com](mailto:yatharthvataliya@gmail.com). All security vulnerabilities will be promptly addressed.

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
