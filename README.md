# BU WordPress Visual Regression assist plugin

This plugin is intended to facilitate gathering URLs from a specific WordPress site. The idea is geared towards visual regression testing. It is Initially developed with the use of BackstopJS in mind but can be adapted as it simply helps in the management of the URLs for testing.

## The name
 The name of the plugin will most likely change in time as its functionality evolve
bu-vis-reg
bu = Boston University
vis = Visual
reg = Regression

## Admin page
The link to the admin page for this plugin is located under “Tools” in the dashboard menu

## Usage
### Flagging pages manually for custom selection
On any page, post, or custom post types, there is a check box on the sidebar to flag a specific page for URL testing. Check the box and hit update if you wish to include such post into the flagged selection.

### URL Request
In admin page, select the type of post or content you wish to get the URLs from and hit “Generate list”.
To use the list, hit “Export list” and the list of URLs will be available for download as a JSON file.

## How it works
The plugin contains a set of custom API endpoints that helps with sending request via the wp-json option built into WordPress. For more information on wp-json visit the WordPress developer codex.

The response is than processes by JavaScript on the client side and generates a list table that can be later customized.

