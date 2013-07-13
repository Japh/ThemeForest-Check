(function( $ ) {
	"use strict";

	$(function() {

		$('#theme-check > h2').html( $('#theme-check > h2').html() + ' with ThemeForest-Check' );

		if ( typeof tfc_intro !== 'undefined' ) {
			$('#theme-check .theme-check').append( tfc_intro.text );
		}

	});

}(jQuery));
