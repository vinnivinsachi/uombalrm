<?php
	/*******************************************************************************
	**This class requires alot of work!!! with a real server
	*******************************************************************************/

	class IpnController extends CustomControllerAction
	{
		protected $shoppingCart; 
		
		public function indexAction()
		{
		
			$DB_Server = "localhost"; //your MySQL Server
			$DB_Username = "root"; //your MySQL User Name
			$DB_Password = "tangoschmango"; //your MySQL Password
			$DB_DBName = "uofmballroom";
		
			//create MySQL connection
			$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password)
			or die("Couldn't connect to MySQL:
			" . mysql_error() . "
			" . mysql_errno());

			//select database
			$Db = @mysql_select_db($DB_DBName, $Connect)
			or die("Couldn't select database:
			" . mysql_error(). "
			" . mysql_errno());
		
		
			$createOrder=false;
			
			$req = 'cmd=_notify-validate';
			
			foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
			
			////echo "<br/>post was: ".$value;
			}
			
			$header ='';
			
			// post back to PayPal system to validate
			/*$header .= "POST https://www.sandbox.paypal.com/cgi-bin/webscr HTTP/1.0\r\n";//getrid of sandbox for real. */

			$header .= "POST https://www.paypal.com/cgi-bin/webscr HTTP/1.0\r\n";//getrid of sandbox for real. 
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			
			
		/*	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); */
			$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); 
			 //get rid of sandbox for real.
			
			/*$this->logger =Zend_Registry::get('orderLog');
			$this->logger->info("1====Here at IPN action'\r'");
			*/
			$this->logger->info("1====fsockepen starting'\r'");
			if (!$fp) 
			{
			
				$this->logger->info("2====fsockepen can not be done'\r'");
					
			} 
			else 
			{
				$this->logger->info("3====fsockepen is open'\r'");

			
				fputs ($fp, $header . $req);
				while (!feof($fp)) 
				{
					$res = fgets ($fp, 1024);
					if (strcmp ($res, "VERIFIED") == 0) 
					{
					// check the payment_status is Compled
					
						if($_POST['invoice']=='')
						{
							$this->logger->info('you are missing invoice!');
						}
						/*elseif($_POST['payment_status']!='Completed')
						{
							$this->logger->info('payment not complete');
						}*/
						else
						{
							
							$invoiceID =  trim($_POST['invoice']);
														
							$this->shoppingCart =new DatabaseObject_ShoppingCart($this->db);
							
							$this->logger->info('invoice id is: '.$invoiceID);
							try
							{
							
								$this->shoppingCart->loadCartOnly($invoiceID);
								$this->logger->info('createOrder is TURE');
								$createOrder=true;
							}
							catch(Exception $ex)
							{
								$this->logger->info($ex->getMessage());
							}
							
							//$this->logger->info('shoppingCart->loadcart is not working');

								
						}
						
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					
					// //echo the response
						//echo "The response from IPN was: <b>" .$res ."</b><br><br>";
						
						$this->logger->info("8888 == The response from IPN was: ".$res);
						//loop through the $_POST array and print all vars to the screen.
						
						foreach($_POST as $key => $value){
						
								//echo $key." = ". $value."<br>";
								
								if($key =='payment_status')
								{
									$this->logger->info($key);
									$this->logger->info($value);
								}
								
								if($key =='invoice')
								{
								$this->logger->info($key);
								$this->logger->info($value);
								}
						}
				
					}
					else if (strcmp ($res, "INVALID") == 0) 
					{
						// log for manual investigation
					
						// //echo the response
						//echo "The response from IPN was: <b>" .$res ."</b>";
						//$this->logger->info("8888 == The response from IPN was: ".$res);
					}
				}
					
				$this->logger->info("at after fclose fp");
				if($createOrder==true)
				{
						$this->logger->warn("starting to do stuff");
						
						
						$CartProduct = $this->shoppingCart->loadCart($this->db, $invoiceID);

						$order = new DatabaseObject_Order($this->db, $invoiceID, $this->shoppingCart->user_id);
						
						//echo "shoppingcart user_id: ".$shoppingCart->user_id;

						$order->user_id = $this->shoppingCart->user_id;
						
						$seller = new DatabaseObject_User($this->db);
						
						$buyer = new DatabaseObject_User($this->db);
						
						$guest = new DatabaseObject_Guest($this->db);
						
						
						if(($this->shoppingCart->buyer_id)>30000000)
						{
							if(($seller->loadByUserId($this->shoppingCart->user_id)) && ($guest->loadByID(($this->shoppingCart->buyer_id)-30000000)))
							{
								$email = true;
								$this->logger->info('at email = true -- guest');

							}
							else
							{
								$email = false;
								$this->logger->info('at email = false -- guest');

							}
						}
						else
						{
							if(($seller->loadByUserId($this->shoppingCart->user_id)) && ($buyer->loadByUserId($this->shoppingCart->buyer_id)))
							{
								$email = true;
								$this->logger->info('at email = true -- user');
							}
							else
							{
								$this->logger->info('at email = false -- user');
							}
						}

						$order->buyer_id = $this->shoppingCart->buyer_id;
						
						$order->url = $invoiceID;

						$order->total_amount = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $invoiceID);
						$this->logger->warn("starting to do stuff 7");
						
						$order->promotion_code = $this->shoppingCart->promotion_code;
						$order->total_before_p = $this->shoppingCart->total_before_p;
						$order->total_after_p = $this->shoppingCart->total_after_p;
					
						$query = "insert into orders (user_id, buyer_id, url, total_amount, ts_created, promotion_code, total_before_p, total_after_p, status) value ('".$this->shoppingCart->user_id."','".$this->shoppingCart->buyer_id."','".$invoiceID."','".$order->total_amount."',NOW(),'".$order->promotion_code."','".$order->total_before_p."','".$order->total_after_p."','pending')";
						
						//echo "first query is: ".$query."<br/>";
						
						
						//$this->logger->warn("query is; ".$query);
						$result = mysql_query($query);
						
						$this->logger->warn("starting to do stuff 7.5--");
						//*/	
						
						//$id = $this->db->lastInsertId();
						//$this->logger->warn("starting to do stuff 8");
						
						$orderid = mysql_insert_id(); 
						
						//$id=$result[0];
						$this->logger->warn("id is: ".$orderid);
						
						////echo $id;

						foreach($CartProduct as $k=>$v)
						{
						
							////echo "<br/>product_id: ".$this->shoppingCartItem[$k]['product_id'];
							////echo "<br/>product_name: ".$this->shoppingCartItem[$k]['name'];

							$orderProfile = new Profile_Order($this->db);
					
							$orderProfile->order_id =$orderid;
							$orderProfile->cart_key = $CartProduct[$k]->cart_key;
							$orderProfile->product_id = $CartProduct[$k]->product_id;
							$orderProfile->product_name = $CartProduct[$k]->product_name;
							$orderProfile->product_type = $CartProduct[$k]->product_type;
							$orderProfile->quantity = $CartProduct[$k]->quantity;
							$orderProfile->unit_cost = $CartProduct[$k]->unit_cost;
							$orderProfile->ts_created = $CartProduct[$k]->ts_created;
					
					
							//loading the product attribute information
							$query = "insert into orders_profile (order_id, cart_key, product_id, product_name, product_type, quantity, unit_cost, ts_created) value ('".$orderid."','".$orderProfile->cart_key."','".$orderProfile->product_id."','".$orderProfile->product_name."','".$orderProfile->product_type ."','".$orderProfile->quantity."','".$orderProfile->unit_cost."','".$orderProfile->ts_created."')";
							
							//echo "<br/>Profile query is: ".$query."<br/>";
							mysql_query($query);
							$id = mysql_insert_id(); 
							
							
						$cart_profile = new Profile_Cart($this->db);
					
						$cart_profile->loadProduct($CartProduct[$k],$CartProduct[$k]->getId(), $CartProduct[$k]->cart_key,$CartProduct[$k]->product_type);
					
					
						$profile_attribute = DatabaseObject_StaticUtility::loadCartProfileAttribute($this->db, $CartProduct[$k]->getId());
					
					
							foreach($profile_attribute as $k=>$v)
							{ 
							
								DatabaseObject_StaticUtility::insertOrderProfileAttribute($this->db,$id, $profile_attribute[$k]);
							
							}
							
						}
						$this->logger->info('after all the profile is done');

						
						if($email ==true)
						{
							if(($this->shoppingCart->buyer_id)>30000000)
							{
								$this->logger->info("sending email at guest before");
								
								try{
								
								$seller->sendEmail('order-notice.tpl', $guest, $invoiceID);
								}
								catch(Exception $ex){
								$this->logger->info("seller email problem");
								$this->logger->emerg($ex->getMessage());
								}
								
								try{
								$guest->sendEmail('order-notice.tpl', $guest, $invoiceID);	
								}
								catch(Exception $ex){
								$this->logger->info("guest email problem");
								$this->logger->emerg($ex->getMessage());
								}				
								$this->logger->info("sending email at guest after");
								
							}
							else
							{
								$this->logger->info("sending email at seller before");

								$seller->sendEmail('order-notice.tpl', $buyer, $invoiceID);
								$buyer->sendEmail('order-notice.tpl', $buyer, $invoiceID);			
								$this->logger->info("sending email at buyer after");
 
							}
							
						}
						else
						{
						
							$this->logger->info('finished email because email was false');

						}
						
						
						$query3 = "delete from invholder where cart_id = '".$invoiceID."'";
						mysql_query($query3);
						
						
						$this->logger->info('runned query at delete invholder');

						
						
						
						$this->shoppingCart->deleteShoppingCart($invoiceID);
						
						$this->logger->info("at create order created!!!!");
					
				}		
				else
				{

				$this->logger->info("at createorder is false");		
				}
			}
			
			
			fclose ($fp); 

			
		}
		
	}
?>