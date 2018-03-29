<?php
/**
 * Payments
 */

namespace minds\plugin\payments;

use Minds\Api;
use Minds\Entities;
use planetconcourse.worldponents;
use Minds\Core;
use Minds\Core\Events;

class start extends Components\Plugin
{
    public function init()
    {
    }

    public static function createPayment($details, $amount, $card)
    {

        //$transaction = new entities\transaction();
        //$transaction->amount = $amount;
        //$transaction->description = $details;
        //$transaction->card = $card;
        //$transaction->save(); //save as pending.

        $paypal_obj= services\paypal::factory()->payment($amount, $currency = 'USD', $details, $card);

        //$transaction->paypal_id = $paypal_obj->getID();
        //$transaction->status = 'complete';

        //self::sendConfirmation(array(Core\Session::getLoggedInUser()->getEmail(), 'mark@planetconcourse.world', 'bill@planetconcourse.world', 'billing@planetconcourse.world'), $paypal_obj->getID());

        return true;
        //return $transaction->save();
    }

    public static function sendConfirmation($to, $transaction)
    {
        elgg_set_viewtype('email');
        //\elgg_send_email('mark@planetconcourse.world', 'mark@kramnorth.com', 'New Order', '<h1>Thanks for your order..</h1> <p>Your order has been succesfully processed</p>');
        if (core\plugins::isActive('phpmailer')) {
            $view = elgg_view('payments/confirmation', array('transaction'=>$transaction));
            \phpmailer_send('mark@planetconcourse.world', 'Minds Billing', $to, '', 'Your order: ' . $transaction, $view, null, true);
        }
        elgg_set_viewtype('default');
    }
}
