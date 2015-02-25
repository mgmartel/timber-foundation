<?php
/*
Template Name: No Sidebar (Centered)

Example of how simple it is to change the layout once layouts are organized in
regions. All this template file does is tell the template engine what layout to
load and then calls on the Timber Template Loader to continue as normal.

*/
TimberFoundationRegions::set_layout( 'centered' );
return TimberTemplateLoader::load_template();