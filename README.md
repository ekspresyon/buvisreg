# BU WordPress Visual Regression assist plugin

This plugin is intended to facilitate gathering URLs from a specific WordPress site. The idea is geared towards visual regression testing. It is Initially developed with the use of BackstopJS in mind but can be adapted as it simply helps in the management of the URLs for testing.

## The name
 The name of the plugin will most likely change in time as its functionality evolve  

bu-vis-reg  
bu = Boston University  
vis = Visual  
reg = Regression  

## Routes
### In use
Get output of all post types URLs: {yoursite address}/wp-json/visreg/v1/allposts

Get output of selected post types URLs: {yoursite address}/wp-json/visreg/v1/someposts

### Upcoming
Get output of all category URLs
{yoursite address}/wp-json/visreg/v1/allcategories

## Admin page
The link to the admin page for this plugin is located under “Tools” in the dashboard menu

## Usage
### Flagging pages manually for custom selection
On any page, post, or custom post types, there is a check box on the sidebar to flag a specific page for URL testing. Check the box and hit update if you wish to include such post into the flagged selection. This feature is under revision for imprived usage. It currently will not function.

### URL Request
In admin page, select the type of post or content you wish to get the URLs from.
To use the list, copy the generated route or bash command and past where necessary.

## How it works
The plugin contains a set of custom API endpoints that help with sending requests for different url sets. For more information on wp-json visit the WordPress developer codex.  

The response is than processes on the client side and generates a list table of published posts that can be later customized.

## Working features
- Copy url request
- Copy bash command
- Multiple post-type filtering

## Not working features
- Flagged filtering
- Randomized selection filtering

