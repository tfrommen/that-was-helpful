var Plugin = Plugin || {};

/* global Plugin, jQuery, tfThatWasHelpfulData */
;( function( Plugin, $, pluginData ) {
	"use strict";

	Plugin.Form = {
		initialize: function() {
			$( '.that-was-helpful__form' ).on( 'click', '.that-was-helpful__submit', function( e ) {
				e.preventDefault();

				var data = {
					_wpnonce : pluginData.nonce,
					action   : pluginData.action,
					vote     : $( this ).val(),
					vote_post: $( this ).siblings( '[name="vote_post"]' ).val()
				};

				$.post( pluginData.url, data, function( response ) {
					if ( response.success ) {
						var $postVotes = $( '.that-was-helpful--' + response.data.post_id );

						if ( $postVotes.length ) {
							var $button = $postVotes.find( '.that-was-helpful__submit' );

							if ( $button.length ) {
								$button.blur();

								if ( response.data.vote ) {
									$button
										.addClass( 'active' )
										.attr( 'title', response.data.titles.active );
								} else {
									$button
										.removeClass( 'active' )
										.attr( 'title', response.data.titles.vote );
								}
							}

							var $votes = $postVotes.find( '.that-was-helpful__votes' );

							if ( $votes.length ) {
								$votes.html( response.data.description );
							}
						}
					}
				} );
			} );
		}
	};

	$( function() {
		Plugin.Form.initialize();
	} );

} )( Plugin, jQuery, tfThatWasHelpfulData );
