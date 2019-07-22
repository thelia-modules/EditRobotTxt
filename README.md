# Edit Robot Txt

Add a short description here. You can also add a screenshot if needed.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is EditRobotTxt.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require your-vendor/edit-robot-txt-module:~1.0
```

## Usage

* After installation, be sure that ```robots``` table is create like :

         CREATE TABLE `robots`
         (
             `id` INTEGER NOT NULL AUTO_INCREMENT,
             `domain_name` VARCHAR(255) NOT NULL,
             `robots_content` TEXT NOT NULL,
             PRIMARY KEY (`id`)
         );        
* Delete your ```robots.txt```.



