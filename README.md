<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<h3 align="center">Test for Vanillasoft</h3>



By Ishtehar Hussain

Task:
Use the latest version of Laravel to send multiple emails asynchronously over API

###Overview:
Build a simple API that supports the sending route
Build a Mail object which accepts email, subject, body, attachments
Make sure that emails are sent asynchronously, i.e. not blocking the send request
Test the route

Used API routes:

__POST
api/send__

The token is used as a URI parameter in the request api_token={{your_api_token}}


###Goal:
The primary goal is for the functionality to work as expected. The idea is to spend about 4 working hours on it, maximum 8 working hours.


###Minimum requirements:

- Have an endpoint as described above that accepts an array of emails, each of them having subject, body, base64 attachments (could be many or none) and the email address where is the email going to
- Attachments, if provided, need to have base64 value and the name of the file
- Build a mail using a standard Laravel functions for it and default email provider (the one that is easiest for you to setup)
- Build a job to dispatch email, use the default Redis/Horizon setup
- Write a unit test that makes sure that the job is dispatched correctly and also is not dispatched if there’s a validation error

*__Bonus requirements:__*
- Have an endpoint api/list that lists all sent emails with email, subject, body and downloadable attachments
- Unit test the above mentioned route (test for expected subject/body/attachment name)

