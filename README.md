# super-assignment

## Dependencies

* `guzzlehttp/guzzle` - to make API calls
* `symfony/cache` - not to disturb the API much
* `vlucas/phpdotenv` - to keep some config data out of files

## Local setup

**1. Run composer install:**
To set up the dependencies run `composer install` the within project's root directory.

**2. Run application:**
To run the app: :`composer serve`

## Run application
Application can be reached from the localhost: 
[http://localhost:7777](http://localhost:7777) - shows the main page.

## Testing

**Run tests:**

Run `php ./vendor/bin/phpunit`