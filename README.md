  Mikko-Test
==============

## Introduction

For this test, we ask you to write a small application, which we use to evaluate your skills. This doesn’t 
have to be a highly scalable super fancy production-ready application, but just something that allows us 
to get an idea of your coding skills. The test is designed in such a way that we can derive a number of 
qualities from your sample code. 
We’ll usually ask you to send us your work within 24 hours, but please tell us if that doesn’t work for you 
for some reason. The actual amount of time you spend on it, is completely up to you. If you need 
frameworks, libraries or databases to write the application, please mention them in the documentation 
for your application.
Once you’ve finished the application, please send your results to your recruitment contact.

## Requirements

You are required to create a small command-line utility in PHP to help a fictional company determine 
the dates they need to pay salaries to their sales department.
This company is handling their sales payroll in the following way:
* Sales staff get a regular monthly fixed base salary and a monthly bonus.
* The base salaries are paid on the last day of the month unless that day is a Saturday or a Sunday 
(weekend).
* On the 15th of every month bonuses are paid for the previous month, unless that day is a 
weekend. In that case, they are paid the first Wednesday after the 15th.
* The output of the utility should be a CSV file, containing the payment dates for the remainder of 
this year. The CSV file should contain a column for the month, a column that contains the salary 
payment date for that month, and a column that contains the bonus payment date. 

## Solution provided

* Windows environment (change test script path for nix like systems)
* PHP 7.2+
* composer 1.8.4
* Symfony (console) 4.2
* PHP unit 7.5
* used a skeleton for console apps: https://github.com/hmazter/console-skeleton

## Assumptions

* Base salaries are payed last day of month except weekends. 
  
  Documentation does not specify if they pay on weekday before weekend or weekday after weekend in that case.
  
* If today is the date of paying salary or bonus; we expect the salary not yet being paid and will as such appear in the CSV  

### How to

* Tests can be run with: ```composer test```
* list functions of the app: ```php app list```
* start the payday app: ```php app app:payday```

