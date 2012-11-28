a:3:{s:5:"child";a:1:{s:0:"";a:1:{s:3:"rss";a:1:{i:0;a:6:{s:4:"data";s:0:"";s:7:"attribs";a:1:{s:0:"";a:1:{s:7:"version";s:3:"2.0";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:1:{s:7:"channel";a:1:{i:0;a:6:{s:4:"data";s:35:"
		
		
		
		
		
		
		
		
		
		
		
	";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:7:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:20:"Joomla! powered Site";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:24:"Joomla! site syndication";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:34:"http://www.joomlacontenteditor.net";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:13:"lastBuildDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 30 May 2008 01:26:42 +0100";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:9:"generator";a:1:{i:0;a:5:{s:4:"data";s:17:"FeedCreator 1.7.2";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:5:"image";a:1:{i:0;a:6:{s:4:"data";s:19:"
			
			
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:4:{s:3:"url";a:1:{i:0;a:5:{s:4:"data";s:65:"http://www.joomlacontenteditor.net/images/M_images/joomla_rss.png";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:18:"Powered by Joomla!";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:34:"http://www.joomlacontenteditor.net";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:24:"Joomla! site syndication";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}s:4:"item";a:5:{i:0;a:6:{s:4:"data";s:23:"
			
			
			
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:14:"Coming Soon...";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:68:"http://www.joomlacontenteditor.net/news/latest-news/coming-soon.html";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:3295:"
There has been a lot of interest, requests and concern regarding the current status of JCE 1.5, and in particluar the Image Manager Extended plugin. I haven't been too good about communicating the status and progress of the project recently, and for this I apologise. Rest assured, JCE 1.5.0 is alive and very well, and a release is imminent. It will also feature one of the most important feature updates to JCE yet, (inspired by conversations at the Dutch Joomla!day) JCE Groups!


Image Manager Extended 


Creating this plugin for JCE 1.5.0 has been quite a lot more work than anticipated, and has required some extensive modifications to the JCE 'API', mainly the inclusion of an event systems to trigger actions after events, eg: onUpload, onFileDelete etc. to handle Image Manager Ext thumbnail and resize operations without having to duplicate existing functions used by all the Manager plugins. For example, after a successful file upload, the onUpload event is triggered which in the Image Manager Ext's case calling an onUpload function to do the resizing, rotating (yes, rotating of images has been added!) and thumbnailing to the uploaded file. A similar thing happens onFileDelete to delete the associated thumbnail and possibly thumbnail folder.


Image rotating has also been added, and is available in the Upload dialog, (see screenshot popup) as well as in the Transform dialog (which includes resizing).


There have been one or two minor improvements too, such as the ability to have rollover images and tooltips at the same time, as well as some general fixes and improvements to the Manager plugins code in general.


The Image Manager Extended will be released as beta 1


	
		
			
			
			
			
		
	


JCE 1.5.0 beta 4 and JCE Groups 


Included in the next JCE 1.5.0 beta 4 and JCE Admin Component RC 3 will be the new Groups system. This is a major change to the way permissions are handled in JCE and presents what is essentially the ability to create individual user and/or user type profiles, each have a unique layout and button configuration, as well as specific editor and plugin parameters. Groups can contain a mix of user types and individual users.


For example, you can create a group for Authors which only has access to Bold, Italic, Underline and the Image Manager. You then set the Image Manager to be restricted to a folder with the groups name, as well as disabling file and folder deleting, set via the plugin's group parameters. For this group you also disable the ability to insert javascript and php code (via the group's editor parameters), and just for good measure, add the user Joe Schmo to this group, because despit the fact he is an Editor, he just no ready for all the features you have assigned to your Editor group.


A default group exists for all default editing user types (which can be edited). Super Administrators have access to everything (always, regardless of what group they are assigned to), and Guests and Registered users are not in any group by default and are therefore presented with a blank editor (you can change this by assigning them to a group or creating a new one).


Here are a couple of screenshots of the JCE Groups Admin.


	
		
			 
			
			 
			
			 
			
		
	


Expect a release this coming week. Guaranteed.

";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:18:"News - Latest News";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Sun, 25 May 2008 08:58:07 +0100";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:1;a:6:{s:4:"data";s:23:"
			
			
			
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:35:"Website issues and component update";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:92:"http://www.joomlacontenteditor.net/news/latest-news/website-issues-and-component-update.html";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:676:"
Unfortunately the move to the new domain has not been without its troubles, and with me in various cities of 2 different countries over the last 2 weeks (still on holiday!) hasn't made the move and subsequant problems any easier to overcome. Nevertheless, I think everything should be working as expected now, and I apologise for any inconvenience caused.


If you are still experiencing any problems, please contact me.


On another note, I have released JCE Admin Component 1.5.0 RC2, which moves the Control Panel buttons and News Feed section to a set of modules. Further modules will also be developed. This should fix the 'fatal error' issues experienced in RC1. 


 

";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:18:"News - Latest News";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 21 Apr 2008 00:28:31 +0100";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:2;a:6:{s:4:"data";s:23:"
			
			
			
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:17:"JCE 1.5.0 updates";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:74:"http://www.joomlacontenteditor.net/news/latest-news/jce-1.5.0-updates.html";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:1068:"
I have just managed to squeeze out a few updates for JCE 1.5.0 before leaving on a bit of a holiday (including the Dutch Joomla!day on Saturday). I will still provide support via the forums during this period.


These updates should fix the Admin Component install issues (in the JCE Admin Component 1.5.0 RC1 release) and a number of important issues in the Editor Plugin and Media/File Manager plugins.


I hope these releases can bring us closer to a Release Candidate for the Editor Plugin and stability for the 1.5.0 project.


I know I promised the Image Manager Extended and Template Manager plugins too, but these aren't quite ready. I hope to have them out very soon.


There is also a little secret project in the works involving JCE Utilities and the Media Manager.... 


Thank you for your support, encouragement and help finding and squashing bugs!


Please use only the latest releases of each plugin/component together. Do not mix and match versions. The new Media and File Manager plugin versions are only compatible with beta3 of the Editor Plugin 

";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:18:"News - Latest News";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 03 Apr 2008 11:09:00 +0100";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:3;a:6:{s:4:"data";s:23:"
			
			
			
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:29:"JCE Utilities for Joomla! 1.5";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:85:"http://www.joomlacontenteditor.net/news/latest-news/jce-utilities-for-joomla-1.5.html";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:740:"
JCE Utilities is now available for Joomla! 1.5, released as JCE Utilities 1.6


Changelog (from 1.5.0)


	Joomla! 1.5.0 version!
	Updated: XHTML Object methods updated for JCE 1.5.x
	Updated: JQuery 1.2.3
	Fixed: Zoom icon positioning fixed, finally, I think.


Install using the Joomla! installer. Publish after installation.


As the Imager Manager Extended and AdvLink Extended are not yet available for JCE 1.5.x, popups will have to be created manually. See this tutorial - Using the JCE Utilities Mambot/Plugin (index.php?option=com_content task=view id=32 Itemid=13)


http://www.cellardoor.za.net/docman/view-document-details/169-jce-utilities-plugin1.6.0.html (docman/view-document-details/169-jce-utilities-plugin1.6.0.html)  


";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:18:"News - Latest News";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Sun, 30 Mar 2008 17:25:16 +0100";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:4;a:6:{s:4:"data";s:23:"
			
			
			
			
			
		";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:23:"JCE at Dutch Joomla!day";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:79:"http://www.joomlacontenteditor.net/news/latest-news/jce-at-dutch-joomladay.html";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:275:"
Well, not in an official capacity, but I wil be there on Saturday 5th April for the Community Day (provided I can get my visa in time!)


For those who don't know what I'm talking about - http://www.joomladag.nl (http://www.joomladag.nl) 


Hope to see some of you there! 

";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"category";a:1:{i:0;a:5:{s:4:"data";s:18:"News - Latest News";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Sun, 16 Mar 2008 12:03:11 +0100";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}}}}}}}}}}}s:7:"headers";a:7:{s:4:"date";s:29:"Thu, 29 May 2008 23:36:58 GMT";s:6:"server";s:156:"Apache/1.3.26 (Unix) Sun-ONE-ASP/4.0.2 mod_auth_pam/1.0a PHP/4.3.11 PHP/3.0.18 mod_ssl/2.8.10 OpenSSL/0.9.6g mod_perl/1.27 mod_jk/1.1.0 FrontPage/5.0.2.2510";s:12:"x-powered-by";s:10:"PHP/4.3.11";s:10:"set-cookie";s:42:"ba4b321c4beeec3e0ef35009f70b3ced=-; path=/";s:19:"content-disposition";s:26:"inline; filename=rss20.xml";s:17:"transfer-encoding";s:7:"chunked";s:12:"content-type";s:35:"application/xml; charset=ISO-8859-1";}s:5:"build";d:20070719221955;}