# [Advanced Custom Field Easy Development](https://github.com/mirkoferraro/wp-advanced-custom-fields-easy-development)

ACFED is a Wordpress plugin that uses [Advanced Custom Field](http://www.advancedcustomfields.com) core in order to register custom fields via PHP in a easier way.

### Why use ACFED?
ACF saves all custom field data into database, that is the slowest and heaviest way to use ACF

ACF suggests you to register your fields via PHP ([read this article](http://www.advancedcustomfields.com/resources/register-fields-via-php/)), but the exported PHP code is very long and difficult to read

ACFED allow you to save some rows of code

### How ACFED work?
You can add ACFED code in yout theme's function.php

First of all you must check if ACFED is active
```php
if ( class_exists( 'ACFED' ) && ACFED::is_active() ) {
	...
}
```

Than you can create your first custom group
```php
$group = new CustomGroup('mygroup', 'options_page == acf-options');
```
The second argument of CustomGroup is the location
Using location like 'options_page == acf-options' creates options pages automatically

Now you can create your custom fields
```php
$field = $group->addField('myfield1', 'Field #1', 'text');
```

If you want to change custom field's attributes use the 'set' function
```php
$field->set('placeholder', 'Insert your informations');
```

You can also use the short form
```php
$group->addField('myfield1', 'Field #1', 'text')
	  ->set('placeholder', 'Insert your informations');
```

In order to use the repeater-type custom field you can use the 'addContainer' function
```php
$repeater = $group->addContainer('myrepeater', 'List', 'repeater');
$repeater->addField('item1', 'Item', 'text');
```

Your final code:
```php
if ( class_exists( 'ACFED' ) && ACFED::is_active() ) {
	
	$group = new CustomGroup('mygroup', 'options_page == acf-options');

	$group->addField('myfield1', 'Field #1', 'text')
		  ->set('placeholder', 'Insert your informations');
	
	$repeater = $group->addContainer('myrepeater', 'List', 'repeater');
	$repeater->addField('item1', 'Item', 'text');
    
}
```