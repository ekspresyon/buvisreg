# BU WordPress Visual Regression assist plugin

This plugin is intended to facilitate gathering URLs from a specific WordPress site. The idea is geared towards visual regression testing. It is Initially developed with the use of BackstopJS in mind but can be adapted as it simply helps in the management of the URLs for testing.

## The name
 The name of the plugin will most likely change in time as its functionality evolve  

bu-vis-reg  
bu = Boston University  
vis = Visual  
reg = Regression  

## Routes
#### In use
Get output of all post types URLs
- {yoursite address}/wp-json/visreg/v1/posts
- {yoursite address}/wp-json/visreg/v1/pages
- {yoursite address}/wp-json/visreg/v1/allposts

#### Upcoming
Get output of all category URLs
- {yoursite address}/wp-json/visreg/v1/allcategories

## No UI
This version contains no user interface. 