Why Bank Local?
===============

This is the theme for [whybanklocal.pvlocalfirst.org](http://whybanklocal.pvlocalfirst.org), 
a WordPress site to promote local banking specifically in the pioneer valley.

The map plugin is will be in another repo, linked here once up.

Setting up the site
-------------------

This is a WordPress site with a custom theme & plugin for a map of banks. 
To set up a dev environment, you should first have a copy of WP running 
locally. The master branch is the theme itself, so you'll put that in 
`wp-content/themes/`. It should work with or without the plugin- without 
the plugin you will have a large empty space at the bottom of the site.

You can then export content from the [live site](http://whybanklocal.pvlocalfirst.org)
to populate your dev site, however the section IDs are currently hardcoded.

TODO (theme only)
-------------------
- Responsive: Currently we're set at 1000px, anything smaller is out of luck. 
- Add a style for pages.
- "SEO": The `<title>` is set, but no other meta tags are. Opengraph & twitter meta would also be good for sharing.
- Related to above, an image for sharing on FB/Twitter/etc, and a favicon.
- Parallax-y effect: the idea was for some things to subtly move - the clouds, waves, seamonster, & bird are good options for this.
- Browser testing would be helpful, but note that until responsive is taken care of, it's a bit awkward on <1000px wide.
