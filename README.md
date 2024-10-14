# NYT Best Sellers API

This API is built on PHP using the [Laravel framework](https://laravel.com/docs/11.x) . It acts as a layer to the New York Times Books API.

### Requirements
- PHP >= 8.1 https://www.php.net/
- Composer https://getcomposer.org/


### Get an NYT API Key
You need to create your own API credentials to access the NYT API.
1. Create a New York Times developer account: https://developer.nytimes.com/accounts/create
2. Go to create a New App: https://developer.nytimes.com/my-apps/new-app
3. Enable the Books API.
4. Create your app.
5. Copy your API key. It will be used when setting up the API.

### API Setup
1. Create `.env` by running the following command on your terminal:
   ```sh
   cp .env.example .env
   ```

2. Set the NYT API key (from the above steps) in your `.env` as:
   ```sh
   NEW_YORK_TIMES_API_KEY="YOUR-API-KEY-HERE"
   ```
3. Run `composer install`
4. Start the app with `php artisan serve`. You should see something like this come up:
   ```sh
    INFO  Server running on [http://127.0.0.1:8000].

    Press Ctrl+C to stop the server
    ```
5. Go to the URL: http://127.0.0.1:8000/api/1/nyt/best-sellers to hit our endpoint.

### Testing
Run `php artisan test`
