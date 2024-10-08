# MF-ansible

This project allows you to automatically provision a Mobile Forces game server together with a responsive website for server management. The website is integrated with Ko-fi and PayPal for donation processing, uses an SQLite3 database to store donation info and displays it on the landing page with more detailed info such as the top donators available on the statistics page

![image](https://github.com/user-attachments/assets/fe2aab4f-1fd9-4e43-916a-09da367a8884)

The project is deployed on Hetzner at https://mf.nofisto.com through GitHub Actions and uses Cloudflare as a CDN and domain registrar, the root of the website code can be found at: `templates/webserver`

# Setup instructions

Put your MobileForces.zip in the root folder and run
```
ansible-playbook -i hosts playbook.yml -u root
```

You may configure various options in the vars.yml file, by deafult this playbook relies on your MobileForces.zip creating a MobileForces folder

The Ansible playbook transfers game files, installs necessary packages and sets up Systemd services for the game server, master server and FastDL of game files through an Apache2 web server which is also used for the website, an SSL certificate is automatically added to it by using Let's Encrypt's certbot tool, these steps are made in a modular way and can be excluded

# Potential improvements

https://www.ericmacedo.com/generating-code-from-templates-using-python-and-jinja2.html

# Thanks to

https://github.com/333networks/Masterserver-Qt5 for their master server implementing the Gamespy v0 protocol

https://github.com/OldUnreal/UnrealTournamentPatches for their updated System64 packages

https://github.com/Studio-42/elFinder for the php file manager

https://github.com/twbs/bootstrap for bootstrap customizeation and compilation with only selected components
