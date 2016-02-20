# krickbooking

Simple web application to book cricket stadium with following criteria
    -  only 1 hr slots are allowed
    -  overlapping bookings are not allowed. 
    -  email address can be used to edit bookings
    -  cancellation is allowed
    

***Manual Instllation Steps:***

Step 1 : Clone repository git@github.com:ghanu/krickbooking.git

Step 2 : Create databse krick_booking

Step 3 : Import datatabse from krickbooking/data/scripts/init_schema.sql

Step 4 : Change database name, user name and password in krickbooking/config/application.ini


***Setup Virutalhost:***

```
<VirtualHost *:80>
    DocumentRoot "path/krickbooking/public/"
    ServerName krickbooking.dev
    SetEnv APPLICATION_ENV development
    <Directory "path/krickbooking/publicpublic/">
        DirectoryIndex index.php
        Order allow,deny
        Allow from all
        AllowOverride All
    </Directory
    #ServerAlias www.dummy-host.example.com
</VirtualHost>
```

```
***Sample API Call to make booking / cancel booking / edit booking ***
http://krickbooking.dev/stadiumbooking/makebooking?email=ghanu@zalora.com&booking_date=2016-02-30&booking_slot=9-10
http://krickbooking.dev/stadiumbooking/editbooking?email=ghanu@zalora.com&booking_date=2016-02-21&booking_slot=9-10&old_booking_slot=10-11&old_booking_date=2016-02-21
http://krickbooking.dev/stadiumbooking/cancelbooking?email=ghanu@zalora.com&booking_date=2016-02-21&booking_slot=9-10
```

```
***Swagger APIS ***
http://krickbooking.dev/swagger#/

```



