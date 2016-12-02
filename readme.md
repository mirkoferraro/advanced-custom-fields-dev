# [Advanced Custom Field Development](https://github.com/mirkoferraro/advanced-custom-fields-dev/blob/master/changelog.md)

ACFD is a Wordpress plugin that uses [Advanced Custom Field](http://www.advancedcustomfields.com) core in order to register custom fields via PHP in a easier way.

### Why use ACFD?
ACF saves all custom field data into database, that is the slowest and heaviest way to use ACF

ACF suggests you to register your fields via PHP ([read this article](http://www.advancedcustomfields.com/resources/register-fields-via-php/)), but the exported PHP code is very long and difficult to read

ACFD allow you to save some rows of code

### How ACFD work?
You can add ACFD code in yout theme's function.php

First of all you must check if ACFD is active
```php
if ( class_exists( 'ACFD' ) && ACFD::isActive() ) {
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
if ( class_exists( 'ACFD' ) && ACFD::is_active() ) {
	
	$group = new CustomGroup('mygroup', 'options_page == acf-options');

	$group->addField('myfield1', 'Field #1', 'text')
		  ->set('placeholder', 'Insert your informations');
	
	$repeater = $group->addContainer('myrepeater', 'List', 'repeater');
	$repeater->addField('item1', 'Item', 'text');
    
}
```

### Examples

Group
```php
$group = ACFD::group('My Group Title', 'post_type == post')
	->set('hide_on_screen', array(
		'categories'
	));
```

Text field 
```php
$group->addField( 'title', 'Title', 'text' )
	->set( 'required', 1 )
	->set( 'placeholder', 'Insert your title here' )
	->set( 'maxlength', 35 );

```

Textarea field 
```php
$group->addField( 'content_text_raw', 'Simple content', 'textarea' )
	->set( 'placeholder', 'Insert your text here' )
	->set( 'maxlength', 3000 )
	->set( 'rows', 8 )
	->set( 'new_lines', 'wpautop' );

```

Number field 
```php
$group->addField( 'points', 'Points', 'number' )
	->set( 'default_value', 1 )
	->set( 'append', 'points of 10' )
	->set( 'min', 1 )
	->set( 'max', 10 );
```

E-mail field 
```php
$group->addField( 'email', 'E-mail', 'email' )
	->set( 'placeholder', 'your@mail.it' );
```

URL field
```php
$group->addField( 'website_url', 'Website', 'url' )
	->set( 'placeholder', 'http://www.google.com' );
```

Password field
```php
$group->addField( 'password', 'Your password', 'password' )
	->set( 'required', 1 );
```

Wysiwyg field
```php
$group->addField( 'content', 'Content', 'wysiwyg' )
	->set( 'tabs', 'all' )
	->set( 'toolbar', 'full' )
	->set( 'media_upload', 1 );
```

Image field
```php
$group->addField( 'image', 'Image', 'image' )
	->set( 'min_width', 120 )
	->set( 'min_height', 120 )
	->set( 'max_width', 160 )
	->set( 'max_height', 160 )
	->set( 'max_size', 2 )
	->set( 'mime_types', 'jpg,png' );
```

File field
```php
$group->addField( 'pdf', 'PDF', 'file' )
	->set( 'max_size', 2 )
	->set( 'mime_types', 'pdf' );
```

Gallery field
```php
$group->addField( 'gallery', 'Gallery', 'gallery' )
	->set( 'min', 3 )
	->set( 'max', 5 )
	->set( 'min_width', 300 )
	->set( 'min_height', 240 )
	->set( 'max_width', 420 )
	->set( 'max_height', 380 )
	->set( 'max_size', 2 )
	->set( 'mime_types', 'jpg,png' );
```

Select field
```php
$group->addField( 'available_colors', 'Available colors', 'select' )
	->set( 'choices', array(
		'#ffffff' => 'White',
		'#000000' => 'Black',
		'#ff0000' => 'Red',
		'#00ff00' => 'Green',
		'#0000ff' => 'Blue',
	) )
	->set( 'default_value', array (
		'#000000',
	) )
	->set( 'allow_null', 0 )
	->set( 'multiple', 0 );
```

Checkbox field
```php
$group->addField( 'authorization', 'Authorization', 'checkbox' )
	->set( 'choices', array(
		'subscriber'    => 'Subscriber',
		'contributor'   => 'Contributor',
		'author'        => 'Author',
		'editor'        => 'Editor',
		'administrator' => 'Administrator',
	) )
	->set( 'default_value', array (
		'editor',
		'administrator'
	) )
	->set( 'toggle', 1 ); // Add 'select all'
```

Radio field
```php
$group->addField( 'type', 'Type', 'radio' )
	->set( 'choices', array(
		'type1' => 'Type #1',
		'type2' => 'Type #2',
		'type3' => 'Type #3',
	) )
	->set( 'other_choice', 1 ); // Allow user to add other choices
```

Single checkbox field (boolean)
```php	
$group->addField( 'active', 'Active', 'true_false' )
	->set( 'default_value', 0 );
```

Post object field
```php
$group->addField( 'related_articles', 'Related articles', 'post_object' )
	->set( 'post_type', array( 'post' ) )
	->set( 'taxonomy', array() )
	->set( 'allow_null', 1 )
	->set( 'multiple', 1 )
	->set( 'return_format', 'object' );
```

Post link field
```php
$group->addField( 'related_links', 'Related links', 'page_link' )
	->set( 'post_type', array ( 'post' ) )
	->set( 'taxonomy', array ( 'category:html' ) )
	->set( 'allow_null', 1 )
	->set( 'multiple', 1 );
```

User field
```php
$group->addField( 'user', 'User', 'user' )
	->set( 'role', array ( 'subscriber' ) )
	->set( 'allow_null', 0 )
	->set( 'multiple', 1 );
```

Map field
```php
$group->addField( 'location', 'Map', 'google_map' )
	->set( 'center_lat', '-37.81411' )
	->set( 'center_lng', '144.96328' )
	->set( 'zoom', 14 )
	->set( 'height', 400 );
```

Date field
```php
$group->addField( 'birthday', 'Birthday', 'date_picker' )
	->set( 'display_format', 'd/m/Y' )
	->set( 'return_format', 'd/m/Y' )
	->set( 'first_day', 1 ); // Monday
```

Color field
```php
$group->addField( 'color', 'Color', 'color_picker' )
	->set( 'default_value', '#FFFFFF' )
```

Message field
```php
$group->addField( 'warning','Warning', 'message' )
	->set( 'message', 'Here your warning' )
	->set( 'new_lines', '' )
	->set( 'esc_html', 0 );

```

Tab field
```php
$group->addField( 'tab', 'My Sub Group Name', 'tab' )
	->set( 'placement', 'left' )
	->set( 'endpoint', 1 );
```

Repeater container
```php
$group->addContainer( 'list', 'List', 'repeater' )
	->set( 'collapsed', $field->get( 'key' ) )
	->set( 'min', '1' )
	->set( 'max', '3' )
	->set( 'layout', 'block' )
	->set( 'button_label', 'Add element' )
	->addField( ... );
```

Flexible-content container
```php
$group->addContainer( 'flexible_content', 'Flexible Content', 'flexible_content', 'layouts' )
	->set( 'button_label', 'Add content' )
	->addContainer( 'block_name', 'Block Label', '', 'sub_fields' )
		->addField( ... );
```

Conditional logic
```php
$field->set( 'conditional_logic', array (
	array (
		array (
			'field' => $other_field->get( 'key ' ),
			'operator' => '==',
			'value' => 'value1',
		),
	),
	array (
		array (
			'field' => $other_field->get( 'key ' ),
			'operator' => '==',
			'value' => 'value2',
		),
	),
) );
```