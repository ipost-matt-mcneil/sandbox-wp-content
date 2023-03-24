#Canada Post Content Hub - Magazine

This project is a WordPress installation with a Webpack V43.5 build process, augmented with a GULP task to 
process individual SVG files.

### Prerequisites

Vagrant installation procedures can be found here:

### Installing

Clone the repository into the themes directory :

`git clone https://user.name@git.cpggpc.ca/scm/cco-blogs/wp-blogs.git`

Install NPM dependancies:

`npm install`

## Deployment

#### Development
There are two build options:

`npm run watch`

*note - if this is a fresh install, you will need to execute `gulp` once before running `npm watch`

This will build the project with the following files and recompile on change:

`./dist/script.dev.js`

`./dist/script.amp.min.css`

`./dist/script.dev.css`

The DEV process utilized BrowserSync for live reloading after a recompile.
The default port being used is :8080, but may be changed in dev.config.js
 in the `BrowserSyncPlugin` plugin section.

#### Production
`npm run build`

This will build the project with the following files and exit:


`./dist/script.dev.min.js`

`./dist/script.dev.min.css`

`./dist/script.amp.min.css`


Rather than refactor this process to further diverge the AMP and regular
builds, there is enough signifigant overlap that the developer is given the freedom to 
choose which files they wish to deploy from a single build/watch process.


 #### SVG Sprite generation
 A single SVG sprite file is generated along with an accompanying SCSS file via a GULP command.  
 This process is run each time a build is or watch is executed, this includes deployment builds.
 
 Command: `gulp`
 
 Consumes: `./svg/*.svg`
 
 Creates:
  
  `./scss/base/_icons.scss`
  
  `./img/sprite.svg`

  `./img/sprite.png`
 
 ### Notes regarding migrating the DB from Dev/Staging to localhost:
 This is intended to be a collection of notes relating to the process of
 replicating the DEV11 environment locally.
 
 1. On DEV11 navigate to Tools/Migrate DB Pro/Settings.
 2. Highlight and copy the URL in Connection Info.
 3. On Localhost navigate to Tools/Migrate DB Pro/Settings.
 4. Select Pull radio option, enter key copied in step 1 into textarea below.
 5. Select `Backup the local database before replacing it/Backup all tables with prefix "wp_"`
 6. Select `Media Files`
 7. If this is the first transfer, select `Save Migration` Profile for future use.
 
 
 The password and user profile migrated from DEV11 *should* work, but if it doesn't.

 Got WP CLI?

 1. `wp user list` to identify your WP user ID (example 6)
 1. `wp user update 6 --user_pass=hello` to update your password.

 Not Got WP CLI? Follow these steps
 1. Visit the site `http://scriptserver.mainframe8.com/wordpress_password_hasher.php`
 and generate a new hash
 1. Open phpmyadmin on localhost: `http://vvv.test/database-admin/`
 2. Open the `wp_users` table
 3. Navigate to and edit the row containing your user profile and paste the Hash from step 1 into the user_pass field
 4. Do not attempt to change you WP password on DEV11.  Bad things will happen concluding with you calling 
 technical support at 1-844-507-7301 to reset your corporate password.
 
 If after migrating to localhost attempting to login returns LDAP error:
 1. Navigate to vagrant shell with `vagrant ssh`
 2. Navigate to WP directory: `cd /srv/www/blogs/htdocs/web/blogs/wp`
 3. Disable LDAP plugin using WP CLI: `wp plugin deactivate simple-ldap-login`
 
 It's possible to change a password on localhost using the following commands.  It's recommended to use the same
 password used on the network.
 1. `vagrant ssh`
 2. `cd /srv/www/blogs/htdocs/web/blogs`
 3. `wp user update richard.renshaw --user_pass=New_Password_Here`
 
 ### Tests
 
 There are no tests configured at this time.