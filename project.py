from project_module import project_object, image_object, link_object, challenge_object

p = project_object('weird_youtube', 'Tangles')
p.domain = 'http://www.aidansean.com/'
p.path = 'weird_youtube'
p.preview_image_ = image_object('http://placekitten.com.s3.amazonaws.com/homepage-samples/408/287.jpg', 408, 287)
p.github_repo_name = 'weird_youtube'
p.mathjax = True
p.links.append(link_object(p.domain, 'weird_youtube', 'Live page'))
p.introduction = 'One of the most fruitful memes on the internet is "That wierd part of YouTube".  I saw an opportunity to createa a service to find the weirdest videos on YouTube, and I made this webpage.'
p.overview = '''This page uses the YouTube Javascript API to load pairs of YouTube videos.  The user then votes on which one they think is "weirder", and two new videos are loaded for comparison.  The backend is handled using PHP with a MySQL database to store and retrieve the video ids.  The user can submit their own videos with client side validation of the URI and server side sanitisation to prevent MySQL injection attacks.  The statistics associated with each video are also displayed, showing how many times each "won" or "lost" a comparison.

This project was never actually released outside my webspace, despite my original intentions.  This is because YouTube is very clear about its branding policies- a third party cannot use the word "YouTube" without explicit permission, and the meme requires the name "YouTube" to be used.  As a result this was only ever shown to my friends and never received much traffic. I may revisit this later and release to the general public with a different name.'''

p.challenges.append(challenge_object('As usual, this uses the YouTube Javascript API and all the difficulties that come with that.', 'The YouTube Javascript API is second nature now.  This wasn\'t difficult at all!', 'Resolved'))

p.challenges.append(challenge_object('The user should be able to recommend videos.', 'The interface to add suggestions had to be simple to use, so I made the form as clean as possible.  The input had to sanitised as well.  The URI is matched to a regular expression client side before submission, and sanitised server side to prevent injection.  The server side sanitising is very easy given that it must consist of exactly 11 characters in the set [A-Za-z0-9_\-].', 'Resolved'))

p.challenges.append(challenge_object('This page needed a catchy motif.', 'I wanted an image of YouTube videos falling from the sky, as if the videos has been rejected and thrown onto a pile.  I had to emulate the YouTube logo using vector graphics with the canvas, then randomly generate an collection of them that wrapped around in the horizontal direction for the wallpaper.  It was fun to make, and I may make a wallpaper generator based on this concept.', 'Resolved'))

