# ls-module-sitemap
Adds a sitemap feature for your LemonStand store

## Installation
1. Download [Sitemap](https://github.com/flynsarmy/ls-sitemap/zipball/master)
1. Create a folder named `sitemap` in the `modules` directory.
1. Extract all files into the `modules/sitemap` directory (`modules/sitemap/readme.md` should exist).
1. Login to the admin area of your store to complete the installation.
1. Done!

## Usage
Setup the sitemap in the System/Settings area. From there you can choose which CMS pages to include on the sitemap as well as whether or not to include individual category pages, product pages and blog posts.
The sitemap is generated using the Sitemap protocol and can be accessed in your root directory (i.e. www.mystore.com/sitemap.xml or www.mystore.com/ls_sitemap).

### Dependencies
The module requires the CMS Themes feature. If you are installing the Sitemap module manually, please ensure you have version 1.3.0 of the CMS module or later.

### Events
Module provides three events that you can use to extend it:
* sitemap:onGenerateSitemap
   Called when sitemap is generated.
   Handler receives Sitemap_Generator object and current Sitemap_Params

* sitemap:onInitSitemapParamsData
   Called to provide default parameter values
   Handler receives Sitemap_Params object

* sitemap:onExtendSitemapParamsModel
   Called when Sitemap_Params model form is generated.
   Handler receives Sitemap_Params object