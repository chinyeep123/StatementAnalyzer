# StatementAnalyzer
This is addon for FusionCMS v6 (https://github.com/fusioncms/fusioncms)

# Installation #
1. Download all files to your FusionCMS `addons/StatementAnalyzer` folder, it is normally located at root folder of the FusionCMS installation. (If there is no `addons` folder there, you may need to create a empty folder `addons`)

2. Run 
```
php artisan addon:discover
php artisan addon:enable StatementAnalyzer
``` 

# Normal Installation 
GrowCRM Laravel Normal Installation  
1. Create a modules folder and pull the package.
 
2. Add In to config/app.php
```
/*
 * Package Service Providers...
 */
....
Ant\StatementAnalyzer\Providers\AddonServiceProvider::class,
```
  
3. Add below code to composer.json
```
  "psr-4": {
      "Ant\\StatementAnalyzer\\": "modules/StatementAnalyzer/src"
  },

```
  
4. Run composer dump-autoload

5. Run command to migrate the tables
```
php artisan migrate
```

6. Go to AddonServiceProvider.php replace the code below.
```
$this->publishes([
    __DIR__.'/../../public' => public_path('vendor/statement-analyzer'),
], 'statement-analyzer');
```

7. Publish the css and js file
```
php artisan vendor:publish --tag="statement-analyzer"
```

8. add in css file and js file
```
 <link href="{{ asset('vendor/statement-analyzer/css/app.css') }}" rel="stylesheet">
 <script src="{{ asset('vendor/statement-analyzer/js/app.js') }}" defer></script>
```

9. Can run php artisan serve and browse
```
{{ domain_url }}/statements
{{ domain_url }}/statement-tags