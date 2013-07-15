Vehicle-Fits-Metator
====================

Module to add to Vehicle Fits to the Metator shopping cart we are creating

See http://metator.com/

#Install
After installing Metator, drop this project in to `./extensions/VehicleFitsMetator`, `cd` to it and run `composer install`. Copy `application.config.local.php.dist` to your `./config/autoload`

#Add The Search
Use this line to call the view helper, which outputs the vehicle search anywhere in your layout (typically sidebar):
```php
<?=$this->vfsearch()?>
```