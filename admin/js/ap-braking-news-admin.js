(function( $ ) {
	'use strict';

	$(document).ready(function(){

		let apbnID = $('input[name="carbon_fields_compact_input[_apbno_current_breaking_id]"]').val();
		let apbnDEFAULT = '/wp-admin/post.php?post='+apbnID+'&action=edit';
		let apbnHREF = $('a.breakingpostedit').attr('href');
		$('a.breakingpostedit').attr('href', apbnHREF + apbnDEFAULT);

	});

})( jQuery );
