<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
	$breadcrumbs->push('Home', route('contact'));
});

Breadcrumbs::register('contact', function($breadcrumbs)
{
	$breadcrumbs->push('Contact', route('contact'));
});