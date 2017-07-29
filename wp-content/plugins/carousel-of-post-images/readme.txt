=== Carousel-of-post-images ===
Tags: javascript carousel,photos,jquery,jcarousel,carousel,photo carousel,posts
Requires at least: 2.0
Tested up to: 3.6.1
Stable tag: 1.07
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SD4XCQVTGAJT8
Author: Richard Harrison
Contributors: RichardHarrison


Fully integrated jcarousel Image Gallery plugin for WordPress to allow quick and easy galleries built from the images attached to posts.

== Description ==

Carousel of Post allows you to quickly and easily put one or more galleries on a page/post using shortcodes. The images in the gallery will be selected from either all images attached to posts, or from images attached to a specific post.

The default is to select 10 random images from all posts.

Important Links:

* <a href="http://chateau-logic.com/content/wordpress-plugin-carousel-post-images/" title="Documentation">Documentation</a>

= Features =

* Uses JCarousel
* Integrates with other galleries (such as NextGen) to reuse the jcarousel and jquery without clashes.
* Many configurable options
* Small
* Uses the builtin wordpress thumbnail sizes for images 

== Installation ==

1. 	Install & Activate the plugin

2.	Use the shortcode in your posts or pages where you want a gallery

3. 	Go to your post/page an enter the shortcode '[carousel-of-post-images imagesize=small visible=2 count=15]' 

== Usage ==
Use the shortcode to display a random selection of images from the posts on your site.

CSS is used to set the sizing of the Carousel areas.


Example: 
 Shows a carousel with 2 images visible
    [carousel-of-post-images imagesize=small visible=2 count=15]


= Defining the number of visible items =

Sometimes people are confused how to define the number of visible items because there is no option for this as they expect (Yes, there is an option visible, we discuss this later).

You simply define the number of visible items by defining the width (or height) with the class .jcarousel-clip (or the more distinct .jcarousel-clip-horizontal and .jcarousel-clip-vertical classes) in your skin stylesheet.

This offers a lot of flexibility, because you can define the width in pixel for a fixed carousel or in percent for a flexible carousel (This example shows a carousel with a clip width in percent, resize the browser to see it in effect).

So, why there is an option visible? If you set the option visible, jCarousel sets the width of the visible items to always make this number of items visible. Open this example and resize your browser window to see it in effect.

== Options == 
<pre>
.=--------------------------------------------------------------------=.
| Property  | Type    | Default       | Description                    |
|-====================================================================-|
| skin      |         | tango         | Skin to use                    |
|=----------*---------*---------------*-------------------------------=|
| imagesize |         | medium        | Size of images to select. Does |
|           |         |               | not affect the display just    |
|           |         |               | the images that are selected   |
|           |         |               | from the posts                 |
|           |         |               | small,medium,large,full        |
|=----------*---------*---------------*-------------------------------=|
| orderby   |         | rand          | Display order, possible        |
|           |         |               | options see Wordress WP_Query  |
|           |         |               | Orderby parameters             |
|=----------*---------*---------------*-------------------------------=|
| postid    |         | all           | The ID of the post to select   |
|           |         |               | images from. If omitted will   |
|           |         |               | select from all posts.May      |
|           |         |               | contain a comma delimited list |
|           |         |               | of posts to include            |
|=----------*---------*---------------*-------------------------------=|
| count     |         | 10            | Number of images to select     |
|=----------*---------*---------------*-------------------------------=|
| div       |         | post-carousel | ID of the list for the images. |
|           |         |               | Only necessary to set when     |
|           |         |               | using more than one post       |
|           |         |               | carousel in a page/post        |
|=----------*---------*---------------*-------------------------------=|
| vertical  | bool    | false         | Specifies wether the carousel  |
|           |         |               | appears in horizontal or       |
|           |         |               | vertical orientation. Changes  |
|           |         |               | the carousel from a left/right |
|           |         |               | style to a up/down style       |
|           |         |               | carousel.                      |
|=----------*---------*---------------*-------------------------------=|
| rtl       | bool    | false         | Specifies wether the carousel  |
|           |         |               | appears in RTL (Right-To-Left) |
|           |         |               | mode.                          |
|=----------*---------*---------------*-------------------------------=|
| start     | integer |             1 | The index of the item to start |
|           |         |               | with.                          |
|=----------*---------*---------------*-------------------------------=|
| offset    | integer |             1 | The index of the first         |
|           |         |               | available item at              |
|           |         |               | initialisation.                |
|=----------*---------*---------------*-------------------------------=|
| scroll    | integer |             3 | The number of items to scroll  |
|           |         |               | by.                            |
|=----------*---------*---------------*-------------------------------=|
| visible   | integer | null          | If passed, the width/height of |
|           |         |               | the items will be calculated   |
|           |         |               | and set depending on the       |
|           |         |               | width/height of the clipping,  |
|           |         |               | so that exactly that number of |
|           |         |               | items will be visible.         |
|=----------*---------*---------------*-------------------------------=|
| animation | mixed   | fast          | The speed of the scroll        |
|           |         |               | animation as string in jQuery  |
|           |         |               | terms (slow or fast) or        |
|           |         |               | milliseconds as integer (See   |
|           |         |               | jQuery Documentation). If set  |
|           |         |               | to 0, animation is turned off. |
|=----------*---------*---------------*-------------------------------=|
| easing    | string  | null          | The name of the easing effect  |
|           |         |               | that you want to use (See      |
|           |         |               | jQuery Documentation).         |
|=----------*---------*---------------*-------------------------------=|
| auto      | integer |             0 | Specifies how many seconds to  |
|           |         |               | periodically autoscroll the    |
|           |         |               | content. If set to 0 (default) |
|           |         |               | then autoscrolling is turned   |
|           |         |               | off.                           |
|=----------*---------*---------------*-------------------------------=|
| wrap      | string  | null          | Specifies whether to wrap at   |
|           |         |               | the first/last item (or both)  |
|           |         |               | and jump back to the           |
|           |         |               | start/end. Options are first,  |
|           |         |               | last, both or circular as      |
|           |         |               | string. If set to null,        |
|           |         |               | wrapping is turned off         |
|           |         |               | (default).                     |
'=--------------------------------------------------------------------='
</pre>
== Frequently Asked Questions == 

= How do I change the size of the carousel = 

This is performed by changing the underlying CSS used by jcarousel; for example
<pre>
  .jcarousel-skin-tango .jcarousel-container-horizontal { width: 990px ; }
  .jcarousel-skin-tango .jcarousel-clip-horizontal { width: 990px ; height: 240px ; }
  .jcarousel-skin-tango .jcarousel-next-horizontal, .jcarousel-skin-tango .jcarousel-prev-horizontal { top: 140px ; }
  .jcarousel-skin-tango .jcarousel-item-horizontal { margin-right: 10px; }
  .jcarousel-skin-tango .jcarousel-direction-rtl .jcarousel-item-horizontal { margin-left: 10px; }
  .jcarousel-skin-tango .jcarousel-item { width: 300px; height: 240px; }
</pre>
Will make a container that is 990x240 px; use this with the imagesize of 280,280 to produce 3 images across in a reasonable format.

= How do I include images from a set of posts =

Use the syntax postid=1,2,3,4 (where 1,2,3,4) are the posts that you wish to include images from.


== Upgrade Notice ==

= 1.05 =
Renamed "size" option to "count" - to make it easier, as there was confusion between size and imagesize.

= 1.04 =
Remove dependancy on timthumb and add better image handling which solves all reported issues with images not being shown.

== Screenshots == 

1. Sample taking all images from one post.
2. Simple administration, only the global skin can be changed, all else is controlled directly by the shortcode or function call
3. Larger differently styled carousel
4. Larger standard tango styled carousel

== Changelog ==

= 1.0 = 
* First Release

= 1.01 =
* Add screenshots

= 1.02 = 
* Removed dependancy on timthumb

= 1.03 = 
No changes

= 1.04 =
* Add ability to have list of posts in postid to specify which posts to use to provide images.
* Use thumbGen if installed. 
* Add the ability to specify a Width,Height in pixels as image size.

= 1.05 =
* Better handling of image counts
* Add extra screenshots
* Tidy up options page
* Add donate button to plugin options
* Rename size field to count (i.e. number of images, as confusing with imagesize)

= 1.07 =
* Wordpress 3.3

= 1.06 =
* Wordpress 3.6.1
