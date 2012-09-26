<?php
class EasyCompressorController extends  EasyCompressorAppController{
  /**
   * Method responsible to combine and compress CSS
   */
  public function css(){
    $this->autoRender = FALSE;
    
    if(isset($this->params->query['f'])){
      $files = explode(',', urldecode($this->params->query['f']));
      
      App::import('Vendor', 'cssmin', array('file' => 'cssmin/CssMin.php'));

      $compressed = NULL;
      
      foreach($files as $c){
        // Regex responsible to replace all url('../etc), url("../etc), url(../etc) by url(../../)
        $compressed .= preg_replace('#url\((["\']?)([\.\.\/]*)#', 'url($1../../', CssMin::minify(file_get_contents(CSS.end(explode('/css/', $c)))) );
      }
      
      header('Content-type: text/css');
      // Enable cache
      header("Expires: ".gmdate('D, d M Y H:i:s', strtotime('+1 month')));
      header("Cache-Control: public, max-age=".strtotime('+30 days'));
      echo trim($compressed);
    }
  }
  
  /**
   * Method responsible to combine and compress scripts
   */
  public function js(){
    $this->autoRender = FALSE;
    
    if(isset($this->params->query['f'])){
      $files = explode(',', urldecode($this->params->query['f']));
            
      App::import('Vendor', 'jsmin', array('file' => 'jsmin/jsmin.php'));
      
      $compressed = NULL;
      
      foreach($files as $c){
        $compressed .= JsMin::minify(file_get_contents(JS.end(explode('/js/', $c)))); 
      }
      
      header('Content-type: application/javascript');
      // Enable cache
      header("Expires: ".gmdate('D, d M Y H:i:s', strtotime('+1 month')));
      header("Cache-Control: public, max-age=".strtotime('+30 days'));
      echo trim($compressed);
    }
  }
}
