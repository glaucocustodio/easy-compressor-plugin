Easy Compressor Plugin 
=======

CakePHP plugin for CSS and Js compression in a easy way.


Features
=======

- Easy to implement and use
- Get CSS and JS directly from CakePHP default assets blocks
- Cache CSS and Js unchanged files
- Avoid cache in changed files
- Less configuration


Requisites
=======

- CakePHP 2.1.0 at least (view blocks is needed)


How it works?
=======

Easy Compressor generates one script and CSS file for layout and other one for current view. The generated HTML tags have a query string with md5 hash from modification time sum of each file to maintain cache while files are not changed.

This plugin use JsMin and CSSMin libraries to compress assets and it currently does not support CoffeeScript, LessCSS and SAAS.


How to install and use
=======

1- Download plugin files and put inside "app/Plugin/EasyCompressor/"

2- Download latest version of "jsmin" and "cssmin" compression libraries and put inside "app/Vendor/jsmin/" and "app/Vendor/cssmin/" respectivelly

2- Add "CakePlugin::load(array('EasyCompressor' => array('routes' => true)));" in "app/Config/bootstrap.php" to load plugin

3- Add "EasyCompressor.EasyCompressor" for helpers array in AppController. Ie:
public $helpers = array('Html', 'Text', 'Form', 'EasyCompressor.EasyCompressor');

4- Call methods responsible to get the compressed CSS and Js in layout, see below:

'''php
// Get scripts included with: $this->Html->script(array('file1'), array('inline' => false, 'block' => 'layout_script'));
echo $this->EasyCompressor->getLayoutScript();
// Get scripts included with $this->Html->script(array('file1'), array('inline' => false));
echo $this->EasyCompressor->getViewScript();

// Get CSS included with $this->Html->css(array('style'), NULL, array('inline' => false, 'block' => 'layout_css'));
echo $this->EasyCompressor->getLayoutCSS();
// Get CSS included with $this->Html->css(array('style'), NULL, array('inline' => false));
echo $this->EasyCompressor->getViewCSS();
'''

5- Set debug level to 0 in "app/Config/core.php" or add "Configure::write('EasyCompressor.enabled', true);" to enable EasyCompressor without minding with debug level


More
=======

If you wanna include scripts files in layout (separated from view scripts) you must use:

$this->Html->script(array('file1'), array('inline' => false, 'block' => 'layout_script'));

For CSS, use:

$this->Html->css(array('style'), NULL, array('inline' => false, 'block' => 'layout_css'));


Scripts and CSS included as default way will be treated as view assets.
