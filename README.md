# Training

This project is used to train developers with refactoring procedures.

## Description

Company "BuyStuff inc." is a big company with 200 employees. They specialize in
online product selling. Their platform "GiveMeYouMoney" receives 20 millions hits per days,
and is generating 1 million revenue per day.

The "legacy" code can be found in the `index.php` file. **Be advised that
the file is already deployed on a "production server"**, so you must keep
 backward compatibility for the function `calculateOrder`, at the risk
 of breaking the code.

The platform offers different kind of product categorized by rarity.

**Rarity**:

* Common items: Items that are easy to find.
* Uncommon items: Items that are harder to come by, but still accessible.
* Rare items: Items that are collectible pieces which are not cheap, and are really hard to come by.

When creating their accounts, customers choose which plan they want to pay for. Each plan
offers them special discounts.

**Customer plan**:

* Bronze: Cost 10$/months
* Silver: Cost 20$/months
* Gold: Cost 30$/months

Requirements
------------

When placing an order on the platform, the items in the customer cart should have these rules applied:

* Uncommon item's price should be boosted by 1.5x
* Rare item's price should be boosted by 2x
* Bronze customer should have 10% rebate on the total of the order
* Silver customer should have 20% rebate on the total of the order
* Gold customer should have 30% rebate on the total of the order
* Gold customer should have 2 rare items for the price of the higher one.

Goal
----

Your Project manager gave you (the developer) the green light to refactor the `calculateOrder()` function so that
the code is more readable by other developers.

Note: Accounting think that there might be a bug hidden somewhere, but nobody was
able to reproduce it. If you can find/fix it, your project manager would be most happy.

Install
-------

You need to have [`composer`](https://getcomposer.org/) installed on your machine.

To install all technical requirements, run in command line:

````bash
php composer.phar install
````

Then you can run unit test by running this command:

````bash
bin/phpunit
````
