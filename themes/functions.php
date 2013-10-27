<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/

/**
* Create a url by prepending the base_url.
*/
function base_url($url) {
  return CHandy::Instance()->request->base_url . trim($url, '/');
}
//-----------------------------------------------------------------------------

/**
* Return the current url.
*/
function current_url() {
  return CHandy::Instance()->request->current_url;
}    
 
//-----------------------------------------------------------------------------    

/**
    * Render all views.
    */
    function render_views() {
      return CHandy::Instance()->views->Render();
    }
//-----------------------------------------------------------------------------    

/**
    * Print debuginformation from the framework.
    */
    function get_debug() {
      $ha = CHandy::Instance(); 
      
      $html = null;
      if(isset($ha->config['debug']['db-num-queries']) && $ha->config['debug']['db-num-queries'] && isset($ha->db)) {
        $html .= "<p>Database made " . $ha->db->GetNumQueries() . " queries.</p>"; 
      }   	  
      if(isset($ha->config['debug']['db-queries']) && $ha->config['debug']['db-queries'] && isset($ha->db)) {
         $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $ha->db->GetQueries()) . "</pre>";
      }   
      if(isset($ha->config['debug']['handy']) && $ha->config['debug']['handy']) {
        $html .= "<hr><h3>Debuginformation</h3><p>The content of CHandy:</p><pre>" . htmlent(print_r($ha, true)) . "</pre>";
      }   
      return $html;
    }


