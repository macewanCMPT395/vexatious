##Installation

To install this project:
   1. Clone the repository using "git clone https://github.com/macewanCMPT395/vexatious.git"
   2. Change into the directory using "cd vexatious"
   3. Run the ./build.sh program to install dependecies and fill the database

- To host the site locally run "php artisan serve"
- The website will then be available in your browser at the url localhost:8000
- To host the site outside your virtual machine run remoteServe script
- You can then access the site outside your VM by searching for the IP address at port 8000 in your browser. 

If this process does not work you can manually install composer using "composer install". Then run php artisan migrate --force as well as php artisan db:seed --force. The project can then be hosted using either of the above methods.


### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
