# MF-ansible

Put your MobileForces.zip in this folder and run
```
ansible-playbook -i hosts playbook.yml -u root
```
You may configure various options in the vars.yml file

By deafult this playbook relies on your MobileForces.zip creating a MobileForces folder

Don't include "$" in your password


todo: https://www.ericmacedo.com/generating-code-from-templates-using-python-and-jinja2.html