## Omeka Custom Tags Display

I created this code as part of a feature request for our site at https://www.digitalcollections.eku.edu where the ask was to dynamically generate a navigation bar for the Browse Tags page.

Functional requests were:

1. Bar should be dynamic (i.e. no navigation should be generated for elements that were not present on the rendered page). 

2. Bar should have corresponding anchor elements inserted at the beginning of corresponding tag array span. There should be an 'E' anchor between the end of tags beginning with 'D' (if present) and the first tag beginning with 'E'.

3. Tag should handle numerals 0-9 as a single subgroup. 1997 and 2001 should share a single anchor tag in the interest of space and UX.

4. Bar should remain present when scrolling down the page so that the user can access all anchor elements at all times.

5. Bar should handle special characters elegantly. 

This code meets the above requirements. I have also included a CSS file with the styling I implemented on our website as an example.

### Implementation

Presently I have altered the `tag_cloud` function in the globals.php Omeka application file. You can add this code as a replacement to in that file or implement and call the code as a new function.

**I intend to expland this code into a robust plugin but I am publishing what I have now in the interest of sharing my approach since I have seen many people interested in doing something like this at the function level in Omeka. Stay tuned.

![Screenshot](screengrabs/screen_grab_1.PNG)

![Screenshot 2](screengrabs/screen_grab_2.PNG)
