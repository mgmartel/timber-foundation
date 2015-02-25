# Lib

All theme logic happens here. The interesting file here is `theme-options.php`. It doesn't actually expose any option panels (yet), but shows how a theme controller can determine the display logic of the regions. For the header, it offers 3 'packages':

* Top bar    -  simply implements the Foundation responsive top bar
* Offcanvas  -  sets up an offcanvas menu, with a tab bar to open it
* Responsive -  uses the top bar template for large screens, but the offcanvas + tab bar on small screens

Simply by changing the value of `TimberFoundation_ThemeOptions::$header_menu_type` you can switch between the different packages. It's not hard to imagine how this can become a powerful way of dealing with theme options.

The other files:

```

admin.php         - Adds buttons and panels to TinyMCE (not as shortcodes, but
                    as styles)

init.php          - Initialization code. A meager instantiation of
                    TimberFoundationSite

nav.php           - The nav walker (no TimberMenu, see comments in file)

regions-theme.php - The child class for TimberRegions, that defines the regions
                    with their defaults. This becomes the main API for puzzling
                    together layouts.

site.php          - The TimberFoundationSite class, that loads stylesheets,
                    registers menu's and widgets, etc.

template.php      - Template functions that require extra logic. Not every bit of
                    template can be as cleanly separated, so there is the template
                    class, that currently takes care of pagination and comments.

theme-options.php - The theme controller. See comments at the top of this file.

```