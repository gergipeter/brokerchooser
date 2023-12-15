
  

<img  src="https://brokerchooser.com/images/brokerchooser-og-image.jpg"  alt="BrokerChooser logo">

  

  

## BrokerChooser Senior Backend Developer Homework

  

1) You have to have PHP and MySQL server on your local machine running.

  

2) Create a sample database `brokerchooser_backend_interview_homework` in order to `php artisan` work


  3) Install

    git clone https://github.com/gergipeter/brokerchooser.git
    cd brokerchooser
    composer update
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed

Test the application: (default url: http://127.0.0.1:8000/)

    php artisan serve

To run the PHP unit tests:

  

    php artisan test

  

Make sure that these extensions are available in your `php.ini`

  

fileinfo.dll

pdo_mysql.dll

  
  

***

Task Requirements:

  

- An A/B test has a name and 2 or more variants

  

- Variants have a name and a targeting ratio. The system decides which variant to select for a given A/B test based on the targeting ratios (compared to each other)

  

- Example: variant A (targeting ratio: 1), variant B (targeting ratio: 2) - in this case, variant B is 2 times more likely to be selected than variant A

  

- An A/B test can be started and stopped, after stopping, it cannot be restarted

  

- At the same time, more A/B tests can run simultaneously

  

- When an A/B test is running:

  

- new sessions should be assigned to one of the variants of the A/B test

  

- the site should behave according to the variant selected

  

- the site should behave consistently in a given session, i.e. it should not behave according to variant A at first and then according to variant B later

  

  

After implementing the above system, create an A/B test (you can use a migration to start it) and demonstrate the usage of the system by changing some behaviour of the site (that is visible to the visitors) based on the A/B test variant.
