<?php

namespace App\Util;

use Exception;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Shop;
use App\Country;

class Util
{
	public static function Mask($mask, $str){

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

    public static function sendMail($name, $sender, $receiver, $message, $attachedFile, $attachedFilename)
    {
        try{
            $data['name'] = $name; 
            $data['message'] = $message;

            $msgError = Util::validateContact($name, $sender, $receiver, $message, $attachedFile, $attachedFilename);        
            if(strlen($msgError) == 0) {
                $receiver = 'fthiagocdo@gmail.com';
                Mail::send('emails.contact', 
                    [
                        'data'=>$data
                    ], 
                    function($mail) use ($name, $sender, $receiver, $attachedFile, $attachedFilename){
                        $mail->from($sender, $name);
                        $mail->replyTo($sender, $name);
                        $mail->to($receiver);
                        $mail->subject('Mail sent through app');
                        if($attachedFile != null){
                            $mail->attachData($attachedFile, $attachedFilename);
                        }
                    }
                );

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

    private static function validateContact($name, $sender, $receiver, $message, $attachedFile, $attachedFilename)
    {
        if(!isset($name)){
            return "Field 'name' must be informed.";
        } else if(!isset($sender)){
            return "Field 'sender email' must be informed.";
        } else if(!isset($receiver)){
            return "Field 'receiver email' must be informed.";
        } else if(!isset($message)){
            return "Field 'message' must be informed.";
        } else if(!filter_var($sender, FILTER_VALIDATE_EMAIL)) {
            return 'Sender E-mail is not valid.';
        } else if(!filter_var($receiver, FILTER_VALIDATE_EMAIL)) {
            return 'Receiver E-mail is not valid.';
        } else if(isset($attachedFile)){
            if(!isset($attachedFilename)){
                return "Field 'file name' must be informed.";
            }
        }

        return '';
    }

    public static function listShops($justOpenedShops)
    {
        try{
            $listShops = collect();
            $shops = Shop::orderBy('name', 'asc')->get();
            
            foreach($shops as $shop){
                if($shop->isOpen()){
                    $shop->available = true;
                    $listShops->push($shop);
                }else if($justOpenedShops == false || $justOpenedShops == 'false'){
                    $shop->available = false;
                    $listShops->push($shop);
                }
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

    public static function splitText($text, $max_length, $split){
        if(isset($split)){
            $arrayText = explode($split, $text);
        }else{
            $arrayText[0] = $text;
        }

        $return = "";
        foreach($arrayText as $string){
            $newString = $string."\n";
            
            while(strlen($newString) > $max_length+1){
                $return = $return.substr($newString, 0, $max_length)."\n";
                $newString = substr($newString, $max_length, strlen($newString));
            }
            if(strlen($newString) > 0){
                $return = $return.$newString;
            }
        }

        return $return;
    }

    public static function listCountries()
    {
        try{
            $countries = Country::orderBy('name', 'asc')->get();
            
            $return['error'] = false;
            $return['list'] = $countries;
            return $return;
        }catch(Exception $e){
            Log::error('Util.listCountries: '.$e->getMessage());
            $return['error'] = true;
            $return['message'] = 'It was no possible complete your request. Please try again later...';
            return $return;
        }
    }
}