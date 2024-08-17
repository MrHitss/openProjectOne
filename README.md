# DOCUMENTATION

## Setup Instruction

1. Install Dependencies:
```php
composer install
```

2. Update .env file with below details
```php
APP_URL=http://127.0.0.1:8000

DB_USERNAME=root
DB_PASSWORD=password

DEBRICKED_USERNAME="username"
DEBRICKED_PASSWORD="password"

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username
MAIL_PASSWORD=password
```

3. Run the migrations and link the storage:
```php
php artisan migrate
php artisan storage:link
```

4. Register a User:

To register a new user, make a POST request to the registration endpoint by using the following cUrl:

```curl
curl --location 'http://127.0.0.1:8000/api/register' \
--header 'Accept: application/json' \
--header 'Cookie: XSRF-TOKEN=eyJpdiI6ImNtQk9VcSsxaGpUajJLRm4zR3d4Y3c9PSIsInZhbHVlIjoiWEg5a2djVXJlMG5JazE5SFdoSlhIMThqalRNOUNIeGhEVVdkaWc5WTZGb3RMa2ZoaVl6VTdZTmZHT3hpUURzUW1vZXo2c3p5b2tXbzFmam9kWjB4NjdxekVYbmkrbk5ZSmJYa2VIclBGekJENldUbHhVd0FoOThCcXdpYmtzeHYiLCJtYWMiOiI4MWEyZWQyZDkxOTRmZjYwM2FmYzM0NzJjYzcyZTBhZTU1MjI3NDk3MDM0M2YxOGI3NGJmYjQxMDA5Mjc1YTlmIiwidGFnIjoiIn0%3D; opentext_session=eyJpdiI6IjFwalkvOGl2aVFDOVVyT29icisweXc9PSIsInZhbHVlIjoiSnpiU0kycjZVV3M4dVNLYVhOaWtXUkNVYWlQSnJ6V0JZWFhyK0dkemtGSCtPaDBYejExQ1ZKNGZzZVBuK2lBcW5vOFRiWjZYa2xINlltdFc4bGFHak55bkxWMk9FWUNvUXBKSXh0ZW16Y3g3RHk3NEUwUzg2QVlPcEQ3WG0rQU4iLCJtYWMiOiJkOTUxY2YyOWNjMjkwOWY2NzI2Y2JmZGNiNmIyMDhiYjJlZDBjZmJhMWU3MmRiYTc4ZGY1NzEyYWRlNmU2NzY3IiwidGFnIjoiIn0%3D' \
--form 'email="hiteshkv75@gmail.com"' \
--form 'password="Hash@pass42"' \
--form 'password_confirmation="Hash@pass42"' \
--form 'name="Hitesh"'
```
   
5. Login:

To login, make a POST request to the login endpoint by using the following cUrl:

```curl
curl --location 'http://127.0.0.1:8000/api/login' \
--header 'Accept: application/json' \
--header 'Cookie: XSRF-TOKEN=eyJpdiI6ImNtQk9VcSsxaGpUajJLRm4zR3d4Y3c9PSIsInZhbHVlIjoiWEg5a2djVXJlMG5JazE5SFdoSlhIMThqalRNOUNIeGhEVVdkaWc5WTZGb3RMa2ZoaVl6VTdZTmZHT3hpUURzUW1vZXo2c3p5b2tXbzFmam9kWjB4NjdxekVYbmkrbk5ZSmJYa2VIclBGekJENldUbHhVd0FoOThCcXdpYmtzeHYiLCJtYWMiOiI4MWEyZWQyZDkxOTRmZjYwM2FmYzM0NzJjYzcyZTBhZTU1MjI3NDk3MDM0M2YxOGI3NGJmYjQxMDA5Mjc1YTlmIiwidGFnIjoiIn0%3D; opentext_session=eyJpdiI6IjFwalkvOGl2aVFDOVVyT29icisweXc9PSIsInZhbHVlIjoiSnpiU0kycjZVV3M4dVNLYVhOaWtXUkNVYWlQSnJ6V0JZWFhyK0dkemtGSCtPaDBYejExQ1ZKNGZzZVBuK2lBcW5vOFRiWjZYa2xINlltdFc4bGFHak55bkxWMk9FWUNvUXBKSXh0ZW16Y3g3RHk3NEUwUzg2QVlPcEQ3WG0rQU4iLCJtYWMiOiJkOTUxY2YyOWNjMjkwOWY2NzI2Y2JmZGNiNmIyMDhiYjJlZDBjZmJhMWU3MmRiYTc4ZGY1NzEyYWRlNmU2NzY3IiwidGFnIjoiIn0%3D' \
--form 'email="hiteshkv75@gmail.com"' \
--form 'password="Hash@pass42"'
```

5. Upload Files:

To upload files, make a POST request to the upload files endpoint by using the following cUrl:

```curl
curl --location 'http://127.0.0.1:8000/api/upload' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 3|y8fFVeIs7nEJ9xFjZz1WgQMWCvuFIme0TaoXebOl2df17427' \
--form 'fileInput[]=@"/Users/hitesh/Downloads/PHP Developer home task v3/composer.lock"' \
--form 'fileInput[]=@"/Users/hitesh/Downloads/PHP Developer home task v3/composer.lock"' \
--form 'fileInput[]=@"/Users/hitesh/Downloads/PHP Developer home task v3/yarn copy.manifest.lock"' \
--form 'fileInput[]=@"/Users/hitesh/Downloads/PHP Developer home task v3/yarn.lock"'
```

6. List Files:

To check the files status, make a POST request to the list files endpoint by using the following cUrl:

```curl
curl --location 'http://127.0.0.1:8000/api/files' \
--header 'Authorization: Bearer 3|y8fFVeIs7nEJ9xFjZz1WgQMWCvuFIme0TaoXebOl2df17427'
```

7. Setup Schedule Run:

```php
php artisan schedule:run
```
