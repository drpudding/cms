/* 
	ADDITIONAL FRONT END JS
	See Gruntfile for base JS 

*/

$(document).ready(function(){
   
   // disable # links
   $( 'a[href="#"]' ).click( function(e) {
      e.preventDefault();
   });

});