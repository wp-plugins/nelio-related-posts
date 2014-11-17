=== Nelio Related Posts ===
Contributors: nelio
Tags: related post, swiftype, search, cached
Requires at least: 3.3
Tested up to: 4.0
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get a list of Related Posts by querying your Swiftype account, or using
WordPress' regular search functions.

== Description ==

Get a list of Related Posts by querying your Swiftype account. If Swiftype is
not available, it uses WordPress' regular search system. By default, the
related post search is performed using one of the available tags, but you can
override it using your own search query string.

> **Custom Templates**<br>
> Version 2.1.0 let's you define your own templates for displaying each related
> post. Just create a directory named `nelioefi` in your theme's directory and
> create the template you want to use such as, for instance,
> `template-name.php`. When inserting the widget, specify that the template is
> `template-name` and you're ready to go!
>
> (In the directory `template-examples` you'll find some examples).

**Note** If you want to use this plugin with your Swiftype account, please keep
in mind you must have the official [Swiftype
Search](https://wordpress.org/plugins/swiftype-search/) plugin installed.

_Featured image by [Thomas
Tolkien](https://www.flickr.com/photos/tomtolkien/4821397096)_


= Features =

* **Swiftype-powered Search** The list of related posts is built using your
Swiftype account.
* **Regular WordPress Search** You can also use the plugin without a Swiftype
account. Just install the plugin and the regular WordPress search will be used.
* **Advanced search** Related posts are based on tags. However, you can use
your own search query.
* **Customization** You can tweak a few details of the related post list, such
as the section title, the number of words in the excerpt, or the number of days
for the cache will be valid.


== Screenshots ==

1. **Easy Settings.** Don't get lost with thousand of options. Tweak the
essentials and you're done!
2. **Custom Search.** Define a custom search query string for each post.


== Changelog ==

= 2.1.0 =
* Use custom templates for rendering related posts for widget.


= 2.0.0 =
* Swiftype Related Posts are now widget based. Place them wherever you want!
* Some minor improvements.
* Added a reference to our A/B Testing service.


= 1.0.3 =
* Added a new helper function for inserting the related posts wherever you
want, by simply editing your (child) theme.


= 1.0.2 =
* Class "related_post_link" added to all related post links (useful for GA)
* Small tweaks


= 1.0.1 =
* Fix: removed an extra anchor 'a' closing tag.


= 1.0.0 =
* First release.
* Get a list related posts using Swiftype and/or regular WordPress search
capabilities.


== Upgrade Notice ==

= 2.1.0 =
Use custom templates for rendering related posts for widget.

