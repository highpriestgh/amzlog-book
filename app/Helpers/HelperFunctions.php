<?php
namespace App\Helpers;

use JD\Cloudder\Facades\Cloudder;

class HelperFunctions
{
    /**
     * Get base URL
     */
    public function getBaseUrl()
    {
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST).$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
    }


    /**
     * Find difference between two datetimes in hours and minutes
     */
    public function getDateTimeDifference(string $startDateTime, string $endDateTime)
    {
        $datetime1 = new \DateTime("$startDateTime");
        $datetime2 = new \DateTime("$endDateTime");
        $interval = $datetime1->diff($datetime2);
        if ($interval->format('%h') <= 0) {
            return $interval->format('%i')."min";
        }
        return $interval->format('%h')."hr ".$interval->format('%i')."min";
    }
    

    /**
     * Generate employee pass code
     */
    public function generateEmployeePassCode()
    {
        $passCode = "";
        for ($i=0; $i < 6; $i++) { 
            $passCode .= mt_rand(0, 9);
        }
        return $passCode;
    }


    /**
     * Generate guest code
     */
    public function generateGuestCode()
    {
        $guestCode = "";
        for ($i=0; $i < 4; $i++) { 
            $guestCode .= mt_rand(0, 9);
        }
        return $guestCode;
    }

    /**
     * Generate employee qr code
     */
    public function generateEmployeeQRCode(string $passcode, string $companyId)
    {
        $qrcode = \QrCode::format('png')->merge('https://res.cloudinary.com/amazing-technologies/image/upload/v1557224968/logbook/logos/logo-3.png', 0.5, true)->size(500)->errorCorrection('H')->generate("$passcode");
        $image = "data:image/png;base64,".base64_encode($qrcode);
        $public_id = 'Employee_qr_code_'.substr(time(), 0, 5);
        Cloudder::upload($image,$public_id , array('folder'=> 'logbook/companies/'.$companyId.'/qr_codes', 'invalidate' => true));
        $upload_result = Cloudder::getResult();
        return $upload_result['secure_url'];
    }

    /**
     * Hash QR code
     */
    public function hasQRCode($code)
    {
        $mask1 = "";
        $mask2 = "";

        for ($i=0; $i < 10; $i++) { 
            $mask1 .= mt_rand(0, 9);
            $mask2 .= mt_rand(0, 9);
        }

        return $mask1.$code.$mask2;
    }

    /**
     * Hash the id's for security
     */
	public function hashId($id) {
		$hashString = md5(time());
        $hashSection1 = substr($hashString,0,10);
        $hashSection2 = substr($hashString,11,10);
        return $hashSection1.$id.$hashSection2;
	}

	/**
     * Unhash the id's for database transactions
     */
	public function unhashId($hashId) {
		$itemId1 = substr($hashId,10);
		$hashLength = strlen($itemId1);
		$itemIdLength = $hashLength - 10;

		return intval(substr($itemId1,0,$itemIdLength));
	}

}
