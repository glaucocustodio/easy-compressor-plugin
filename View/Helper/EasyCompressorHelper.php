<?php
/**
 * Easy Compressor Plugin - compress Js and CSS in easy way
 * @author Glauco Custódio (@glauco_dsc) - http://github.com/glaucocustodio
 * http://blog.glaucocustodio.com - http://glaucocustodio.com
 */
App::uses('HtmlHelper', 'View/Helper');
class EasyCompressorHelper extends HtmlHelper{
  
  /**
   * Method responsible to generate hash from sum of modification time of all files and to prepare
   * files string that will be compressed
   */
  public function getTagVariables($assets = array(), $type = NULL){
    if($type == 'css'){
      $basePath = CSS; $delimiter = '/css/';
    }else{
      $basePath = JS; $delimiter = '/js/';
    }

    $modificationTime = 0;
    foreach($assets as $c){
      $modificationTime += filemtime($basePath . end(explode($delimiter, $c)));
    }
    
    return array(md5($modificationTime), urlencode(implode(',', $assets)) );
  }
  
  /**
   * Method responsible to return a hash from current page (controller.action)
   */
  public function getPageHash(){
    return md5($this->params['controller'].$this->params['action']); 
  }
  
  /**
   * Method responsible to return view css, getting them by default css block
   */
  public function getViewCSS(){
    preg_match_all('#href=\"([^"]*)\"#', $this->_View->Blocks->get('css'), $viewCSS);
        
    if(isset($viewCSS[1]) && !empty($viewCSS[1])){
      if(Configure::read('debug') == 0 || Configure::read('EasyCompressor.enabled')){
        list($viewModificationTime, $viewFiles) = $this->getTagVariables($viewCSS[1], 'css');
      return sprintf('<link rel="stylesheet" type="text/css" href="%s&p='.$this->getPageHash().'&mt='.$viewModificationTime.'"/>'.PHP_EOL, Router::url('/easy_compressor/easy_compressor/css.css?f='.$viewFiles));
      }else{
        return $this->getUncompressedCSS($viewCSS[0]);
      }
    }
    return;
  }
  
  /**
   * Method responsible to return uncompressed CSS
   */
  public function getUncompressedCSS($assets = array()){
    $css = NULL;
    foreach($assets as $c){
      $css .= sprintf('<link rel="stylesheet" type="text/css" %s />'.PHP_EOL, $c);
    }
    return $css;
  }
  
  /**
   * Method responsible to return CSS from 'layout_css' block
   */
  public function getLayoutCSS(){
    // Get all included CSS from 'layout_css' block
    preg_match_all('#href=\"([^"]*)\"#', $this->_View->Blocks->get('layout_css'), $layoutCSS);

    if(isset($layoutCSS[1]) && !empty($layoutCSS[1])){
      if(Configure::read('debug') == 0 || Configure::read('EasyCompressor.enabled')){ 
        list($modificationTime, $files) = $this->getTagVariables($layoutCSS[1], 'css');
        return sprintf('<link rel="stylesheet" type="text/css" href="%s&mt='.$modificationTime.'"/>'.PHP_EOL, Router::url('/easy_compressor/easy_compressor/css.css?f='.$files));
      }else{
        return $this->getUncompressedCSS($layoutCSS[0]);
      }
    }
    return;
  }
  
  /**
   * Method responsible to return uncompressed scripts
   */
  public function getUncompressedScripts($assets = array()){
    $scripts = NULL;
    foreach($assets as $c){
      $scripts .= sprintf('<script type="text/javascript" %s ></script>'.PHP_EOL, $c);
    }
    return $scripts;
  }
  
  /**
   * Method responsible to return view scripts, getting them by default scripts block
   */
  public function getViewScript(){
    preg_match_all('#src=\"([^"]*)\"#', $this->_View->Blocks->get('script'), $viewScripts);
    
    if(isset($viewScripts[1]) && !empty($viewScripts[1])){
      if(Configure::read('debug') == 0 || Configure::read('EasyCompressor.enabled')){
        list($viewModificationTime, $viewFiles) = $this->getTagVariables($viewScripts[1], 'js');
        return sprintf('<script type="text/javascript" src="%s&p='.$this->getPageHash().'&mt='.$viewModificationTime.'"></script>'.PHP_EOL, Router::url('/easy_compressor/easy_compressor/js.js?f='.$viewFiles));
      }else{
        return $this->getUncompressedScripts($viewScripts[0]);
      }
    }
    return;
  }
  
  /**
   * Method responsible to return scripts from 'layout_script' block
   */
  public function getLayoutScript(){
    // Get all scripts included from 'layout_script' block
    preg_match_all('#src=\"([^"]*)\"#', $this->_View->Blocks->get('layout_script'), $layoutScripts);
    
    if(isset($layoutScripts[1]) && !empty($layoutScripts[1])){
      if(Configure::read('debug') == 0 || Configure::read('EasyCompressor.enabled')){
        list($modificationTime, $files) = $this->getTagVariables($layoutScripts[1], 'js');
        return sprintf('<script type="text/javascript" src="%s&mt='.$modificationTime.'"></script>'.PHP_EOL, Router::url('/easy_compressor/easy_compressor/js.js?f='.$files));
      }else{
        return $this->getUncompressedScripts($layoutScripts[0]);
      }
    }
    return;
  }
}
?>
