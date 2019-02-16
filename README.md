# Q-Management

## Setup
To install the application locally follow these steps:
* Setup and install an Apache and PHP server
  * Simple to do by downloading and installing [MAMP](https://www.mamp.info/en/)
* Clone the GitHub repo into your webserver root folder
  * If installed MAMP it will be the `MAMP/htdocs` folder
*initialize local database
  * Ensure your MAMP server is running and go to your [PHP admin page](http://localhost/phpMyAdmin/)
  * Navigate to Databases and create a new database called "test_db"
  * Finally run the [generateDB script](https://localhost/q-management/generateDB.php) found in the webserver root folder
* Can now go to `localhost/q-managment` in a web browser and should get the main index page
