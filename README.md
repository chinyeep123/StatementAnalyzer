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
Laravel Normal Installation  
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
5. Run php artisan migrate --path=/path/modules/StatementAnalyzer/database/migrations

