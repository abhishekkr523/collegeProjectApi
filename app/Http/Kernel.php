protected $routeMiddleware = [
    // Other middleware...
    'auth.user' => \App\Http\Middleware\AuthenticateUser::class,
];
