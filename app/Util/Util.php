<?php

namespace App\Util;

use Exception;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Shop;

class Util
{
	public static function Mask($mask,$str){

	    $str = str_replace(" ","",$str);

	    for($i=0;$i<strlen($str);$i++){
	        $mask[strpos($mask,"#")] = $str[$i];
	    }

	    return $mask;
	}

	public static function redirectHome()
    {
        $message = 'User not authorized.';
        $typeMessage = 'red white-text';

        return redirect()->route('site.home')
            ->with( ['message' => $message] )
            ->with( ['typeMessage' => $typeMessage] );
    }

    public static function createDateFromDatabase($dateFromDatabase)
    {
    	$year = substr($dateFromDatabase, 0, 4);
    	$month = substr($dateFromDatabase, 5, 2);
    	$day = substr($dateFromDatabase, 8, 2);
    	$hour = substr($dateFromDatabase, 11, 2);
    	$minute = substr($dateFromDatabase, 14, 2);
    	$second = substr($dateFromDatabase, 17, 2);
    	
        return Carbon::create($year, $month, $day, $hour, $minute, $second, 'Europe/London');
    }

    public static function formatDate($date)
    {   
        return $date->format('d/m/Y h:i A');
    }

    public static function sendMail($data)
    {
        try{
            $name = $data['name'];
            $email = $data['email'];
            $message = $data['message'];
            
            $msgError = Util::validateContact($name, $email, $message);        
            if(strlen($msgError) == 0) {
                $receiver = 'fthiagocdo@gmail.com';
                Mail::send('emails.contact', 
                    [
                        'data'=>$data
                    ], 
                    function($mail) use ($name, $email, $receiver){
                        $mail->from($email, $name);
                        $mail->replyTo($email, $name);
                        $mail->to($receiver);
                        $mail->subject('Mail sent through app');
                });

                $return['error'] = false;
                $return['message'] = 'Your message was sent.';
                return $return;
            }else{
                $return['error'] = true;
                $return['message'] = $msgError;
                return $return;
            }
        }catch(Exception $e){
            Log::error('Util.sendMail: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }

    private static function validateContact($name, $email, $message)
    {
        if(!isset($name)){
            return "Field 'name' must be informed.";
        } else if(!isset($email)){
            return "Field 'email' must be informed.";
        } else if(!isset($message)){
            return "Field 'message' must be informed.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'E-mail is not valid.';
        }

        return '';
    }

    public static function listShops($openedShops)
    {
        try{
            $listShops = collect();
            $shops = Shop::orderBy('name', 'asc')->get();
            
            if($openedShops){
                foreach($shops as $shop){
                    if($shop->isOpen()){
                        $listShops->push($shop);
                    }
                }
            }else{
                $listShops = $shops;
            }

            $return['error'] = false;
            $return['list'] = $listShops;
            return $return;
        }catch(Exception $e){
            Log::error('Util.listShops: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }
}