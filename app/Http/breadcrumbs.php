<?php

// Home
Breadcrumbs::register( 'home', function ( $breadcrumbs ) {
	$breadcrumbs->push( 'Home', route( 'home' ) );
} );

Breadcrumbs::register( 'contact', function ( $breadcrumbs ) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push( 'Contact', route( 'contact' ) );
} );

Breadcrumbs::register( 'en', function ( $breadcrumbs ) {
	/*$breadcrumbs->push('Contact', route('contact'));*/
} );