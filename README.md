# Easy Compressor Plugin 

CakePHP plugin for CSS and Js compression in a easy way.


## Features

- Easy to implement and use
- Get CSS and JS directly from CakePHP default assets blocks
- Cache CSS and Js unchanged files
- Avoid cache in changed files
- Less configuration


## Requisites

- CakePHP 2.1.0 at least (view blocks is needed)


## How it works?

Easy Compressor generates one script and CSS file for layout and other one for current view. The generated HTML tags have a query string with md5 hash from modification time sum of each file to maintain cache while files are not changed.

This plugin uses JsMin and CSSMin libraries to compress assets and it currently does not support CoffeeScript, LessCSS and SAAS.


## How to install and use

1- Download plugin files and put inside `app/Plugin/EasyCompressor/`

2- Download latest version of "jsmin" (https://github.com/rgrove/jsmin-php/blob/master/jsmin.php) and "cssmin" (http://code.google.com/p/cssmin/downloads/list) compression libraries and put inside `app/Vendor/jsmin/` and `app/Vendor/cssmin/` respectively

3- Add `CakePlugin::load(array('EasyCompressor' => array('routes' => true)));` in `app/Config/bootstrap.php` to load plugin

4- Add `EasyCompressor.EasyCompressor` for helpers array in `app/Controller/AppController` like below.

	public $helpers = array('Html', 'Text', 'Form', 'EasyCompressor.EasyCompressor');

5- Call methods responsible to get the compressed CSS and Js in layout, see below:

	// Get scripts included with: $this->Html->script(array('file1'), array('inline' => false, 'block' => 'layout_script'));
	echo $this->EasyCompressor->getLayoutScript();
	// Get scripts included with $this->Html->script(array('file1'), array('inline' => false));
	echo $this->EasyCompressor->getViewScript();

	// Get CSS included with $this->Html->css(array('style'), NULL, array('inline' => false, 'block' => 'layout_css'));
	echo $this->EasyCompressor->getLayoutCSS();
	// Get CSS included with $this->Html->css(array('style'), NULL, array('inline' => false));
	echo $this->EasyCompressor->getViewCSS();

6- Set debug level to 0 in `app/Config/core.php` or add `Configure::write('EasyCompressor.enabled', true);` to enable EasyCompressor without minding with debug level


### More

If you wanna include scripts files in layout (separated from view scripts) you must use:

	$this->Html->script(array('file1'), array('inline' => false, 'block' => 'layout_script'));

For CSS, use:

	$this->Html->css(array('style'), NULL, array('inline' => false, 'block' => 'layout_css'));


Scripts and CSS included as default way will be treated as view assets.

I have made a post in my blog (in pt-BR) where I explain how to use EasyCompressor too, see http://blog.glaucocustodio.com/2012/09/28/compressor-de-javascript-e-css-para-cakephp-easy-compressor
