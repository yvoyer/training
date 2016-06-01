Training
========

Currently there is a bug in the system, and the ProductManager demanded to fix it.
You decided to refactor the code to make it more readable, while adding tests.

Requirements
------------

* Uncommon item should be boosted by 1.5x
* Rare item price should be boosted by 2x
* Bronze customer should have 10% rebate on order
* Silver customer should have 20% rebate on order
* Gold customer should have 30% rebate on order
* Gold customer should have 2 for one (Rare items only). They should pay for the highest items.

Install
-------

You need to have (`composer`)[https://getcomposer.org/] installed on your machine.

To install all technical requirements, run in command line:

````bash
composer install
````

Then you can run unit test by running this command:

````bash
vendor/bin/phpunit
````
