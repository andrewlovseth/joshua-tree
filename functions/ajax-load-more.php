<?php

add_filter('alm_filters_projects_filter_details_market', function(){ 
   
   // Define empty array
   $values = []; 
   
   // Get all markets
   $args = array(
	   'order' => 'ASC',
	   'orderby' => 'name',
       'post_type' => 'market',
       'numberposts' => -1
   );  
   $terms = get_posts($args);
   
	// Loop terms
   if($terms){      	  
      // Add All Item
      $values[] = array( 
        'label' => '-- All Markets  --',
        'value' => ''
     );	
    foreach( $terms as $term ) { 
         $values[] = array(
            'label' => $term->post_title,
            'value' => $term->ID
         );
      }		
	
   }		
   return $values; // Return values	
});


add_filter('alm_filters_projects_filter_detail_services', function(){ 
   
    // Define empty array
    $values = []; 
    
    // Get all services
    $args = array(
        'order' => 'ASC',
        'orderby' => 'name',
        'post_type' => 'service',
        'numberposts' => -1,
        'post_parent' => 0
    );  
    $terms = get_posts($args);

    
     // Loop terms
    if($terms){      	  
       // Add All Item
       $values[] = array( 
         'label' => '-- All Services  --',
         'value' => ''
      );	
     foreach( $terms as $term ) { 
          $values[] = array(
             'label' => $term->post_title,
             'value' => $term->ID
          );
       }		
     
    }		
    
    return $values; // Return values	
 });


 add_filter('alm_no_results_text', function(){
	return '<div class="no-results"><p>No results found.</p></div>';
});


add_filter('alm_display_results', function(){
	return '';
});