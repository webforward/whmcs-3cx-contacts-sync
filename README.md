# WHMCS 3CX Contacts Sync

Built with Laravel Zero. WHMCS 3CX Contacts Sync copies all of your WHMCS Billing System clients and contacts in to your 3CX Phone Server phonebook so that your customers' names display on your 3CX handsets with Caller ID.

Set this application up as a cron to run as frequently as you like. Do note that it will overwrite your existing 3CX contact list.

## Preparation

You will need PHP 7.4 or greater installed, php-pgsql extension and composer [https://getcomposer.org/download/](https://getcomposer.org/download/). 

This can be installed on your 3CX linux server but will require more knowledge of Linux as 3CX does not use the standard Debian repositories. I may add a guide at a later date as to how I have done this.

You will need to create WHMCS API access credentials. The API Role will need permission to `Get Clients` and `Get Contacts`. 
You can read how to create API credentials here: [https://docs.whmcs.com/Manage_API_Credentials](https://docs.whmcs.com/Manage_API_Credentials).
You will need to allow your IP address to access the API. You will find this in `Setup > General Settings > Security`.

To populate the contacts list / phonebook within 3CX we need the postgres database credentials which sit being the 3CX system. 
You can find these credentials by connecting to your 3CX server and viewing the file `/var/lib/3cxpbx/Bi/3CXPhoneSystem.ini` and looking below `[CfgServerProfile]`.

## Installation

Clone the project to a directory on your server.

`git clone https://github.com/webforward/whmcs-3cx-contacts-sync.git`

Go into the directory and copy the `.env.example` file to `.env`

```
cd whmcs-3cx-contacts-sync
cp .env.example .env
```

Edit the variables inside `.env`

Install all required packages:

`composer install`

To run and test the sync:

`php application contacts:sync`

Note: Your 3CX contacts list may not update straight away due to caching, however you can test by checking your handset directory or making an incoming call from a number in whmcs.

Once tested and working, create a cronjob to run as frequently as you wish.


