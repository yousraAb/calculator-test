# Commission Calculator

Run `composer install` to install dependencies.

To run the script:
```bash
php bin/calculate.php input.txt
```

To run tests:
```bash
vendor/bin/phpunit
```

API Reliability Note
During the execution of this task, I noticed that the API endpoint https://lookup.binlist.net/—used to retrieve BIN information—can occasionally be unavailable or rate-limited (the free tier has a 5 requests per hour limit). This can lead to failures or inconsistent behavior when processing multiple transactions in a short time span.

For the purpose of refactoring and testing, I implemented error handling and used mocked responses in the unit tests to ensure reliability and maintain test coverage regardless of API availability.

To improve the project further, I structured the code to allow for easy replacement of the BIN provider service in the future. This aligns with the extensibility requirement described in the task.
