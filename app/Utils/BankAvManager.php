<?php
namespace App\Utils;
use App\Models\Application;
use App\Models\BankAccount;
use App\Models\BankVerification;
use http\Env\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BankAvManager{
    private Collection $applications;
    private BankVerification $accountVerification;
    public function __construct($accountVerification,$applications)
    {
        $this->applications = $applications;
        $this->accountVerification = $accountVerification;
    }

    public function generateHeader()
    {

        $headerIdentifier = $this->getHeaderIdentifier();
        $originatorCode = $this->getOriginatorCode();
        $responderCode = $this->getResponderCode();
        $fileUploadDate = $this->getFileUploadDate();
        $fileRefNo = $this->getFileReferenceNumber($this->accountVerification->id);
        $totalCount = $this->getTotalNumberOfRecords();
        $filler = $this->getFiller();

        return $headerIdentifier . $originatorCode . $responderCode . $fileUploadDate . $fileRefNo . $totalCount . $filler;
    }

    public function generateRecords()
    {
        $content = '';
        $recordIdentifier = $this->getRecordIdentifier($this->accountVerification);

        foreach ($this->applications as $application) {
            $recordRefNumber = $this->getRecordReferenceNumber($application->bankAccount);
            $destinationIfsc = $this->getDestinationIfsc($application->bankAccount);
            $accountNumber = $this->getBankAccountNumber($application->bankAccount);
            $beneficiaryName = $this->getBeneficiariesName($application->bankAccount);
            $consumerId = $this->getConsumerId();
            $accountFlag = '01';
            $beneficiaryFlag = str_pad(' ',2,' ');
            $consumerName = str_pad(' ', 200, ' ');
            $adhaarNumber=str_pad(' ', 15, ' ');
            $mobileNumber=str_pad(' ', 15, ' ');
            $email=str_pad(' ', 70, ' ');
            $filler=str_pad(' ', 16, ' ');

            $content .= $recordIdentifier . $recordRefNumber
                . $destinationIfsc . $accountNumber . $beneficiaryName
                .$consumerId.$accountFlag.$beneficiaryFlag .$consumerName
                .$adhaarNumber.$mobileNumber.$email.$filler .PHP_EOL;
        }
        return $content;
    }

    public function toString(): string
    {
        $header = $this->generateHeader();
        $record = $this->generateRecords();
        return $header .PHP_EOL. $record;
    }

    public function getRecordIdentifier(BankVerification $av)
    {
        return str_pad($av->id, 2, '0',STR_PAD_LEFT);
    }

    public function getRecordReferenceNumber(BankAccount $bankAccount)
    {
        return str_pad($bankAccount->id, 15, ' ', STR_PAD_RIGHT);
    }

    public function getDestinationIfsc(BankAccount $bankAccount)
    {
        return str_pad(trim($bankAccount->ifsc), 11, '0', STR_PAD_RIGHT);
    }

    public function getBankAccountNumber(BankAccount $bankAccount)
    {
        return str_pad(trim($bankAccount->ac_no), 35, ' ', STR_PAD_RIGHT);
    }

    public function getBeneficiariesName(BankAccount $bankAccount)
    {
        return str_pad(strtoupper(trim($bankAccount->ac_holder)), 100, ' ', STR_PAD_RIGHT);
    }



    private function getHeaderIdentifier()
    {
        return '30';
    }



    public function getConsumerId()
    {
        return rand(10000000000000000,99999999999999999);
    }

    public function getBeneficiaryNameFlag()
    {

    }

    public function getAdhaarNumber()
    {

    }

    public function getMobileNumber()
    {
        return str_pad(' ', 15, '',STR_PAD_LEFT);
    }

    public function getEmail()
    {
        return str_pad(' ', 70, '',STR_PAD_LEFT);
    }

    public function getRecordFiller()
    {
        return str_pad(' ', 16, '',STR_PAD_LEFT);
    }

    private function getOriginatorCode()
    {
        return env('APP_DEBUG')?Str::upper(Str::random(4)).'       ':'TEST' .'        ';
    }

    private function getResponderCode()
    {
        $result = 'SBIN';

        return $result.'       ';
    }

    public function getFileUploadDate()
    {
        return now()->format('dmY');
    }

    public function getFileReferenceNumber($id)
    {
        return 'MZ'.str_pad($id, 8, '0', STR_PAD_LEFT);
    }

    public function getTotalNumberOfRecords()
    {
        $count= count($this->applications);
        return str_pad($count, 6, '0', STR_PAD_LEFT);
    }
    public function getFiller()
    {
        $space = '';
        for ($i = 0; $i < 452; $i++) {
            $space .= ' ';
        }

        return $space;
    }

    public function generateResFileName(): string
    {
        $originatorCode = 'BPCL';
        $responderCode='HDFC';
        $loginId = 'User-1';
        $uploadDate = now()->format('dmY');
        $sequence = str_pad($this->accountVerification->id, '7', '0', STR_PAD_LEFT);
        return'AV-' . $originatorCode .'-'. $responderCode .'-'. $loginId .'-'. $uploadDate .'-'.$sequence. '-' . 'RES.txt';
    }
    public function generateInpFileName(): string
    {
        $originatorCode = 'BPCL';
        $responderCode='HDFC';
        $loginId = 'User-1';
        $uploadDate = now()->format('dmY');
        $sequence = str_pad($this->accountVerification->id, '7', '0', STR_PAD_LEFT);
        return'AV-' . $originatorCode .'-'. $responderCode .'-'. $loginId .'-'. $uploadDate . '-'.$sequence. '-' . 'INP.txt';
    }
}
