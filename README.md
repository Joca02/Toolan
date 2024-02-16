# Toolan- Social media website

## About
- This website is created using  Three-Tier architecture. For front end project uses HTML5, CSS3, Bootstrap, jQuery, AJAX. Back end is made entirely in PHP, MySQL is used as a database. 
Project was made for the Web Applications class I took in my 3rd year of University, meaning the whole project was done from scratch including database design. Most of the features were inspired by Facebook, Instagram and Twitter. 
- Project currently supports two types of users: user and admin.
- User interactions are supported with CRUD operations.

## Features
### User
- User is allowed to log into the system or to create a new account
- After successful log-in, user is redirected to the home page
- Home page contains navigation and post section
- Navigation allows user to search other users by typing their name, clicking on the searched user navigates to his/her profile
- Navigation also displays the current user's name and profile picture, both on Home page and on Profile page of any user
- Post section allows user to post his/her own posts that are either just text or a photo with description
- Below this section user can see posts from other users, that the user is following, newest at the top
- User can like, dislike, comment, view all likes, view all comments on a post
- Clicking on a user's profile picture redirects to their profile page
- If user is viewing his own profile, he can edit it by changing name, profile description or profile picture
- Each user has a default profile picture that is set after the successful registration
- User Bob can delete only his own posts, he cannot delete posts from Alice
- When Bob visits Alice's profile, he can follow, follow back or unfollow her
- Alice's profile displays all posts from Alice, same as Bob's profile only displays posts made by Bob
- When user scrolls to the bottom of the page, if there are more posts to be shown, they will be loaded additionally
- User can log out by clicking "Log Out" in the navigation bar and his session will end

### Admin
- Admin is invisible to all users, meaning he can't be found when searching for users
- On Home page, admin can view all posts from all users
- Admin cannot like or comment the post, he can only see comments and people who clicked like on the post
- The admin cannot delete posts
- On the home page, admin can view all of the banned users
- When on user's profile, admin cannot follow/unfollow but he can ban/unban the user
- When banning the user, admin chooses date in the future when the ban ends and enters a reason for the ban
- When banned user tries to log into the social media, he will be welcomed with the alert displaying reason for the ban and date when the ban ends
- Admin can choose to unban user which will allow user to continue browsing the social media as usual
- If admin doesnt unban user manually, ban will be removed after the specified end date

## How to run
Install XAMPP,after that start Apache localhost and MySQL. Find folder where you have installed XAMPP (default Disk C) and navigate to "xampp/htdocs/". Clone project inside htdocs folder. Import database into the phpMyAdmin and save. Last step is to enter localhost path
into the browser and you will be redirected to the log in page.
