=== Tab My Content ===
Contributors: eoni
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=B2H2MRHMRQS2Y
Tags: tab, tabs, content
Requires at least: 4.4
Tested up to: 4.8
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Author URI: https://www.patricelaurent.net
Plugin URI: https://www.patricelaurent.net/portfolio/plugin/tab-my-content/

Tab My Content is an easy way to add tabs inside your content, page or post. A lightweight and easy way to Tab your content.

== Description ==

Tab My Content allow you to add as many tabs you want inside your content. Each tabs can be reused as many times as you want.
There's nothing to configure, just activate it and use it, that's all. No more complicated admin options.

* Tabs are are created with jQuery
* Style are limited to the only necessary in order to avoid to break your theme style.
* JS & CSS are enqueued only on post or page that use the Tabs system. It will not slow down your website by enqueuing unneeded assets
* Use the custom post Type native functionality to an easy way to add and manage your tabs.
* Tabs can be exported from the native Wordpress Export tool
* Multilingual Ready
* Drag reordering for tabs. Reorder your tabs simply with your mouse

Information and Documentation available at the [official Website](https://www.patricelaurent.net/portfolio/plugin/tab-my-content/).


== Installation ==

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser.
To do an automatic install of, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “tab-my-content” and click Search Plugins. Once you’ve found our plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now".

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Frequently Asked Questions ==

= Is it possible to display tabs inside another Tabs ? =

Yes it is. In order to do this, you must use the shortcode (See the Shortcode Section)

= How can is style the tabs ? =

All the public part displayed in front end is wrapped inside the tabsmc_selector container.
With a bit of CSS, you can easily do it.

#tabsmc_selector ul li {
    background-color:#000;
    color: #FFF;
}


== Shortcode ==

You can also display tabs inside your content with a shortcode. Thus is particulary usefull when you want to display the same tabs in more than one post.

The shortcode allow one parameters, a list of ids seperate by coma.

`[tabmc_by_ids ids=1,2,3,99]`

Using this shortcode allow you to select which tabs to display, anywhere, even inside another tab.

== Screenshots ==

1. Screen to add a tab and how link this tab to a current post, page, or any other type with the autocompletion selector.
2. Edit Tab. You can change the linked page and have direct access to adit or display the content currently linked to this tab
3. Manage Tabs directly from the page or post screen. YOu can reorder tabs from here, simply by dragging it with your mouse
4. Front-end in action, with minimal css. Style it as you want, without css interferences
5. Tabs One
6. Tabs Two
7. tabs Three

== Changelog ==

= 1.0.0 =

* Add - Initial release.

[See changelog for all versions](https://raw.githubusercontent.com/plaurent75/tab-my-content/master/changelog.txt).

== Upgrade Notice ==

= 1.0 =
Just have a try!.
