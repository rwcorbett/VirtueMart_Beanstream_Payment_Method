**Please note that this is now under the MIT Licence, which you can read in the LICENCE.txt file.**

----
# Beanstream Payment Processing Plugin
* takes the customer offsite to enter in the creditcard info on Beanstream's server
* the DB is queried to auto-fill most of the sections on the form
* the payment form option for "Allow Price Modification" should be set to 'no' on your Beanstream control panel

### HOW TO INSTALL:  _see images included in the zip_
1. YOU WILL NEED TO FILL YOU MERCHANT ID IN ON LINE 51 below.
2. create a new payment method using payment class = `ps_payment` and method type = `HTML-Form based`
3. copy and paste this entire PHP block (line 1 to line 70) into the configuration block

----
* _based on the PayPal module that is included with VirtueMart_
* date: 11 June 2010 (updated: 29 Jan 2015)
* author: Robb Corbett / Cape Breton Web Design
* repo: rwcorbett/VirtueMart_Beanstream_Payment_Method
* copyright: :copyright: Robb Corbett / Cape Breton Web Design
* github: @rwcorbett
* contact: robb.corbett+beanstream@gmail.com  ~~robb@cbwebco.com~~

### :bangbang: _Warning_ :bangbang:

_if you choose to use this implementation you are welcome to, but please leave this header inplace. I assume no liability for the functioning of this module on your site. Nor do I really have time to support it. You can try to email me - if it's an easy question then I'll do my best to answer. If you don't hear back from me in my thread or via comments - it's not because I don't like you... it's just that I'm super-busy and probably do not have time... you've been warned!_

## VERSION HISTORY
* ver 1.0 - release
* ver 1.01 - line 60 - inserted simple PHP Mail out - have NOT tested this.
* ver 1.1 - added MIT Licence... be free little scripts, be free! also, I don't have time to support this...
<<<<<<< HEAD
* ver 1.99 - FINAL. There will be no further updates to this code.
=======
* ver 1.11 - FINAL. There will be no further updates to this code.

>>>>>>> origin/master
----
