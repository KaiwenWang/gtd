<?php
function companyInfo( $c, $o){
    if(get_class($c) != 'Company') bail('companyInfo requires a Company object');

    $r = getRenderer();

    $address = $c->get('street').'<br>';
    if ($c->get('street_2')) $address.= $c->get('street2').'<br>';
    if ($c->get('city')) 	 $address.= $c->get('city').',';
    $address.= $c->get('state').'<br>';
    $address.= $c->get('zip');

    $balance = $c->calculateBalance(array('end_date'=>Util::date_format_from_time()));

    $c->get('notes') ? $notes = ' 
        <div class="notes-box">
        <div class="notes-content">	
        '.nl2br(str_replace(array('<','>'), array('&lt;','&gt;'), $c->get('notes'))).'
        </div>
        </div>'
        : $notes = '';

    $contacts = '';
    if($primary = $c->getPrimaryContact()) $contacts.= $r->view('contactDetail',$primary);
    if($billing = $c->getBillingContact()) $contacts.= $r->view('contactDetail',$billing);
    if($technical = $c->getTechnicalContact()) $contacts.= $r->view('contactDetail',$technical);


    $billingStatus = $c->get('billing_status');
    if($billingStatus == 'Up To Date') {
        $billingStatus = '<div class="billing-status">Billing Status: '.$billingStatus.'</div> ';
    }else if($billingStatus == 'Collections' || $billingStatus == 'Overdue') {
        $billingStatus = '<div class="billing-status billing-alert">Billing Status: '.$billingStatus.'</div> ';    
    }

    return '
        <div class="company-info-header">
        <div class="company-info">
        <h2>
        '.$c->getName().' 
        </h2>
        '.$billingStatus.'
        <div class="detail"><a href="index.php?controller=Client&id='.$c->get('id').'">(client view)</a></div>
        <div class="company-balance">
        Current Balance: $ '.$balance.'
        </div>

        </div>
        <div class="address">
        '.$address.'<br>
        '.$c->getPhone().'
        </div>
        <div class="clear-both"></div>
        <div class="address">
        Client Since: '.$c->getData('date_started').'
        </div>
        <div class="status">
        '.$c->getStatus().'
        </div>
        </div>
        <div class="company-contacts">
        '.$contacts.'
        </div>
        '.$notes.'	
        <div class="clear-both"></div>
        ';
}
