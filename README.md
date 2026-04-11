# MF-ansible

This project allows you to automatically provision a Mobile Forces game server together with a responsive website for server management. The website is integrated with Ko-fi and PayPal for donation processing, uses an SQLite3 database to store donation info and displays it on the landing page with more detailed info such as the top donators available on the statistics page. [![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/filipopo/MF-ansible)

![image](https://github.com/user-attachments/assets/fe2aab4f-1fd9-4e43-916a-09da367a8884)

The project is deployed on Hetzner at https://mf.nofisto.com through GitHub Actions and uses Cloudflare as a CDN and domain registrar, the root of the website code can be found at: `templates/webserver/website`

The website was made with `symfony new website --version="7.2.x"` and the symfony cli was installed with

```bash
curl -sS https://get.symfony.com/cli/installer | bash
sudo mv "$HOME/.symfony5/bin/symfony" /usr/local/bin/symfony
```

## Setup instructions

Put your MobileForces.zip in the root folder and run

```bash
ansible-playbook playbook.yml -u root -i mf.nofisto.com,
```

You may configure various options in the vars.yml file, by deafult this playbook relies on your MobileForces.zip creating a MobileForces folder

The Ansible playbook transfers game files, installs necessary packages and sets up Systemd services for the game server, master server and FastDL of game files through an Apache2 web server which is also used for the website, an SSL certificate is automatically added to it by using Let's Encrypt's certbot tool, these steps are made in a modular way and can be excluded

Run these commands in the [website](./templates/webserver/website/) folder to see if you have everything needed to run the app

```bash
composer install
symfony check:requirements
```

Then start it with

```bash
ADMIN_PASSWORD=P@ssword123! php bin/console doctrine:migrations:migrate -n
export APP_SECRET=secret KOFI_TOKEN=token KOFI_NAME=admin
symfony server:start
```

Some other environment variables can be found in `.env`

```bash
APP_ENV=dev
DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"
COST_HISTORY='[{"date":"2023-10-22 15:35:11","cost":12.49},{"date":"2026-04-01 00:00:00","cost":16.49}]'
KOFI_CURRENCY=€
```

## Useful info

If you can't change the apache vhost run `composer require symfony/apache-pack` which will make a .htaccess file in `public/`

Consider optimising the php config: https://symfony.com/doc/current/performance.html

You can test the donation route after setting KOFI_TOKEN with

`curl -L --data-urlencode data@data.json http://127.0.0.1:8000/donate_notify`

If you change the database files run `php bin/console make:migration`

If you need to change the password, downgrade `php bin/console doctrine:migrations:execute --down DoctrineMigrations\\Version20250107003305` and then migrate again

## Thanks to

[Masterserver-Qt5](https://github.com/333networks/Masterserver-Qt5) for the master server implementing the Gamespy v0 protocol

[elFinder](https://github.com/Studio-42/elFinder) and [FMElfinderBundle](https://github.com/helios-ag/FMElfinderBundle) for the file manager

[UnrealTournamentPatches](https://github.com/OldUnreal/UnrealTournamentPatches) for the updated System64 packages
