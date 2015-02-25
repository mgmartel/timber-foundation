![Timber Foundation](https://raw.github.com/mgmartel/timber-foundation/master/screenshot.jpg)

# Timber Foundation

This is Timber Foundation, a starter theme for [WordPress](http://wordpress.org/) and [Timber](https://github.com/jarednova/timber/) using [Zurb Foundation](http://foundation.zurb.com/) and [Timber Regions](https://github.com/mgmartel/timber-regions). It is heavily based on the [Reverie](http://themefortress.com/reverie/) Foundation theme.

This theme is intended as a base for building your own Foundation themes using Timber Regions. It is also a proof-of-concept to show the power of the Timber Regions framework. Every directory and file is documented, so it is also a good introduction into working with Timber Regions. 

To get started, just browse through this repo! Every folder comes with its own `README`, to guide you through understanding the code.

![Timber Foundation in action](https://raw.github.com/mgmartel/timber-foundation/master/screenshot-1.jpg)

There no theme demo site yet. We built the [Remaintenance website](https://remaintenance.io/) using a child-theme of Timber Foundation.


## Installing the theme

If you haven't already, install the [Timber](https://wordpress.org/plugins/timber-library/) plugin and the [Timber Regions](https://github.com/mgmartel/timber-regions) theme.

Get into your `wp-content/themes` directory and clone the repo:

```sh
$ git clone https://github.com/mgmartel/timber-foundation.git
```

You can now activate the theme and start playing with it.

## Editing the styles

To edit the styles, you first need to install Foundation. Read the [Foundation SASS docs](http://foundation.zurb.com/docs/sass.html#other) for some background info. To start, you need to install [NodeJS](http://nodejs.org/), [Bower](http://bower.io/) and [Compass](http://compass-style.org/) (nobody said the stack was going to be small).

Then, you `cd` into the theme folder and run:

```sh
$ bower install
```

Foundation will now automatically be installed in `bower_components`. This path is already included by the Compass config, so after this you are good to go with:

```sh
$ compass watch
```

Now you are ready to edit the SCSS styles and settings and start customizing the theme.

Even though it has its own parent theme, Timber Regions does not use the parent/child relationship from the WP core. This means you can still use Timber Foundation as a parent theme for your own themes.

## Future development

The theme is now a good base to quickly prototype a child theme using Foundation. Seriously, for mocking up designs and layouts it makes for incredibly rapid prototyping.

However, together with Timber Regions, I think it has the potential to become a quite powerful theme framework for any WP project. This should mostly happen in Timber Regions, so that the theme framework stays CSS framework agnostic. Maybe Timber Regions should be based more on `_s` and use that as a guide to make sure all the bases are covered. 

I am curious to hear anybody else's thoughts on this!

## Credits

This theme is built on top of a huge stack, building further on the hard open source work of many others. Here's the shortlist:

### Stack

* [Foundation](http://foundation.zurb.com/) by [Zurb](http://zurb.com/)
* [Timber Regions](https://github.com/mgmartel/timber-regions)
* [Timber](https://github.com/jarednova/timber/) by [Upstatement](http://upstatement.com/) and @jarednova
* [WordPress](http://wordpress.org/)

### Theme Basis

* [Reverie](http://themefortress.com/reverie/) by [Theme Fortress](http://themefortress.com/)

![Timber Foundation in action](https://raw.github.com/mgmartel/timber-foundation/master/screenshot-2.jpg)
