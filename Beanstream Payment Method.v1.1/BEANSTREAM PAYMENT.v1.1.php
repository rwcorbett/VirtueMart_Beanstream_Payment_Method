<?php
/**Please note that this is now under the MIT Licence, which you can read in the LICENCE.txt file.**/
/****
----
# Beanstream Payment Processing Plugin
* takes the customer offsite to enter in the creditcard info on Beanstream's server
* the DB is queried to auto-fill most of the sections on the form
* the payment form option for "Allow Price Modification" should be set to 'no' on your Beanstream control panel

* _based on the PayPal module that is included with VirtueMart_
* date: 11 June 2010 (updated: 29 Jan 2015)
* author: Robb Corbett / Cape Breton Web Design
* repo: rwcorbett/VirtueMart_Beanstream_Payment_Method
* copyright: :copyright: Robb Corbett / Cape Breton Web Design
* github: @rwcorbett

** contact me: ~~robb@cbwebco.com~~  robb.corbett+beanstream@gmail.com **

_if you choose to use this implementation you are welcome to, but please leave this header inplace. I assume no liability for the functioning of this module on your site. Nor do I really have time to support it. You can try to email me - if it's an easy question then I'll do my best to answer. If you don't hear back from me in my thread - it's not because I don't like you... it's just that I'm super-busy and probably do not have time... you've been warned!_

## VERSION HISTORY
* ver 1.0 - release
* ver 1.01 - line 60 - inserted simple PHP Mail out - have NOT tested this.
* ver 1.1 - added MIT Licence... be free little scripts, be free! also, I don't have time to support this...
* ver 1.11 - FINAL. There will be no further updates to this code.
----
****/

$db1 = new ps_DB();
$q = "SELECT country_2_code FROM #__vm_country WHERE country_3_code='".$user->country."' ORDER BY country_2_code ASC";
$db1->query($q);
$url = "https://www.beanstream.com/scripts/payment/payment.asp";
//https://www.beanstream.com/scripts/payment/payment.asp?merchant_id=## YOUR MERCH ID HERE ##
$fName = $dbbt->f("first_name");
$lName = $dbbt->f("last_name");
$tax_total = $db->f("order_tax") + $db->f("order_shipping_tax");
$discount_total = $db->f("coupon_discount") + $db->f("order_discount");
$shipping = sprintf("%.2f", $db->f("order_shipping"));
$post_variables = Array(
	//"errorPage"=>"https://www.beanstream.com/samples/order_form.asp", // ## NOT REQUIRED ##
	//"trnCardNumber"=>"5100000010001004", //test MC number
	//"trnExpMonth"=>"12", //testing
	//"trnExpYear"=>"12", //testing
	"trnOrderNumber"=>$db->f("order_id"),
	"trnAmount"=>round( $db->f("order_subtotal")+$tax_total+$shipping-$discount_total, 2),
	"trnCardOwner"=>$dbbt->f("first_name")." ".$dbbt->f("last_name"),
	"ordAddress1"=>$dbbt->f('address_1'),
	"ordAddress2"=>$dbbt->f('address_2'),
	"ordCity"=>$dbbt->f('city'),
	"ordProvince"=>$dbbt->f('state'),
	"ordPostalCode"=>$dbbt->f('zip'),
	"ordName"=>$dbbt->f("first_name")." ".$dbbt->f("last_name"),
	"ordEmailAddress"=>$dbbt->f('user_email'),
	"ordPhoneNumber"=>$dbbt->f('phone_1'),
	"ordCountry"=>$db1->f('country_2_code'),
	//****************************************************************************
	"merchant_id"=>"YOUR_MERCH_ID" // << FILL THIS IN WITH YOUR MERCH ID NUMBER ##
	//****************************************************************************
);
if( $page == "checkout.thankyou" ) {
$query_string = "?";
foreach( $post_variables as $name => $value ) {
	$query_string .= $name. "=" . urlencode($value) ."&";
	}
// ## SEND AN EMAIL ##
// NOTE: I haven't tested this mailout yet... it could be modified to
// send a confirmation email upon successful transaction. I am not sure which
// variables Beanstream sends back to server upon successful (or failed) transaction.
$to = "foo@example.com";
$subject = "the subject";
$message = "hello world from PHP Mail\nthe transaction ID was " . $db->f("order_id");
$headers = "From: bar@example.com" . '\r\n' . "Reply-To: bar@example.com" . '\r\n' . "X-Mailer: PHP/" . phpversion();
mail($to, $subject, $message, $headers);
// ## END PHP MAIL ##
vmRedirect( $url . $query_string );
} else {
// ## MODIFY THIS TEXT TO SUIT YOUR NEEDS ##
echo ' <div class="BS"> <h3>Please read the following information, and click the button to continue.</h3> <p>You will be directed to a secure payment form hosted by Beanstream, where you may pay for your order using VISA or Mastercard.  Once we receive confirmation of payment from Beanstream, we will ship your order.  Thank you.</p> </div>';
echo '<form class="BS" name="BS_FORM" action="'.$url.'" method="post" target="_blank">';
echo '<label><h4>Proceed to Credit Card Processing &rarr;</h4></label> <input type="image" name="submit" src="https://www.beanstream.com/public/assets/images/media/beanstream_secure/beanstream_secure_light.gif" alt="Click to pay with Beanstream - secure online payment processing!" />';
foreach( $post_variables as $name => $value ) {
echo '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars($value).'" />';
}
echo '</form>';
}
?>
