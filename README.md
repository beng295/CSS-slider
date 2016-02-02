## CSS-slider

This is a slider created to run using minimal coding (PHP and CSS with no javascript).  It is designed to run using a MySQL database to store image filenames, a slide sorting order, capability to make the slide inactive, and a caption (with title, description and link/button).  It is capable of displaying 2 or more slides.

## Motivation

The reason for going this route with a slider was to create a simple and easy to understand but also versitle slider while avoiding complex coding and javascript.  

It was also a test to push the limits of CSS3 animations/keyframes in a slider application.

## Installation

1.)  Istallation begins with first defining a few styles within your stylesheet:

section.content1 defines the main container for the slider and is responsive to its parent container.

.slideInfo defines styling for the captions on each slide.

2.)  Set up your database and table information.  These Definitions are set in the front() function.

3.)  The slider() function calculates and displays the slider and its content based on your defined mysql table.

