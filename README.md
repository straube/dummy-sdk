# Dummy SDK

This SKD implements an inexistent API. Its only purpose is to demonstrate how to create an SDK compatible with Laravel's 
container service.


## Instalation

The recommended way to add the SDK to your PHP project is using **Composer**.

1. Add the project repository to your `composer.json` file:
    
        {
            "repositories": [
                {
                    "type": "vcs",
                    "url": "git@github.com:straube/dummy-sdk.git"
                }
            ]
        }
    
2. Then add the requirement:
    
        $ composer require staube/dummy-sdk


### Laravel

If you are building an app upon Laravel, it's possible to take advante to from its 
[service container](https://laravel.com/docs/container) to inject the SDK classes into your app classes.

Add the service provider to `/config/app.php`:

    $providers = [
        
        ...
        
        Straube\Dummy\Laravel\DummyServiceProvider::class,
        
    ];

To set the params used by the SDK, you have to publish the config files:

    $ php artisan vendor:publish --provider="Straube\Dummy\Laravel\DummyServiceProvider"

Then go to `/config/dummy.php` and update the values as you wish.

You now are able to inject the SDK classes into your application. For instance, you may use the `Client` in a controller 
this way:

    <?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Controllers\Controller;
    use Straube\Dummy\Client;
    
    class UserController extends Controller
    {
        /**
         * The Dummy API client.
         *
         * @var Client
         */
        protected $client;
        
        /**
         * Create a new controller instance.
         *
         * @param  Client $client The Dummy API client.
         * @return void
         */
        public function __construct(Client $client)
        {
            $this->client = $client;
        }
        
        /**
         * Show the current user.
         *
         * @return Response
         */
        public function show()
        {
            $sites = $this->client->getUser();
            return view('user.show', [ 'user' => $user ]);
        }
    }


## Usage

Creating a new `Client` instance:

    use Straube\Dummy\Client;
    
    define('DUMMY_USER', 'username'); // The API user
    define('DUMMY_PASSWORD', '***');  // The API password
    
    $client = new Client(DUMMY_USER, DUMMY_PASSWORD);

You may refer to the source code for more details on how to use the SDK.


## Testing

To run the tests you may set some environment vars. This way:

    $ DUMMY_USER=username \
        DUMMY_PASSWORD=*** \
        vendor/bin/phpunit
