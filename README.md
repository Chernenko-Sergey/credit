# Сredit service

Thank you for choosing our software.

Set up project recommendations:
+ copy app/config/parameters.yml.dist to app/config/parameters.yml
+ fill it with real data according to your configuration
+ create/configure database according to parameters.yml
+ install/update composer dependencies
+ fill database with some data

There are 2 ways you can go through:
 - Send post request to /credit/customer with json. Required data: 
   + firstName
   + lastName
   + dateOfBirth
   + Salary
   + creditScore
 - Follow /credit/customer/*customer_id* url, with customer id from database customer table.
 
>System will imitate curl request in both cases.
The first one returns a json response, and the second one shows simple template.

You might find this commands useful to set up project:
```
composer update
doctrine:schema:update
cache:clear
```


