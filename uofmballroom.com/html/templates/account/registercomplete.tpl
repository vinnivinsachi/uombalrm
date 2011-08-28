{include file='header.tpl' section='registercomplete'}

<p>Thank you {$user->profile->first_name|escape}, your registration is now complete. </p>

<p>Please sign in through the side panel.</p>

<p>Your confirmation has been e-mailed to you at {$user->profile->email|escape}. If you did not receive an email, you email might be routed to your SPAM box.</p>

<p>If you forgot about your password, you may request one through "forgot your password"</p>

{include file='footer.tpl'}