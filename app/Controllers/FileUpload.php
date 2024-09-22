<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Tickets;
error_reporting(E_ALL);
ini_set('display_errors', '1');

class FileUpload extends BaseController
{
    protected $Tickets;

    public function __construct()
    {
        $this->Tickets = new Tickets(); 
    }
    public function index()
    {
        
        
        if ($this->request->getMethod() == 'POST')
        {
            #echo "hello";die;
            $file = $this->request->getFile('excelFile');
            $checkOption = $this->request->getPost('check_option');
            
            if ($file->isValid() && !$file->hasMoved())
            {

                $filePath = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/', $filePath);
                
                $csvData = $this->parseCsv(WRITEPATH . 'uploads/' . $filePath);
                $duplicates = $this->checkForDuplicates($csvData, $checkOption);

                if (empty($duplicates)) {
                    foreach ($csvData as $data) {
                       
                        $this->Tickets->insert($data);
                    }
                                        
                    session()->setFlashdata('message', 'Data saved successfully!');
                    session()->setFlashdata('alert-type', 'success');

                } else {
                    
                    session()->setFlashdata('message', 'Duplicates found: ' . json_encode($duplicates));
                    session()->setFlashdata('alert-type', 'danger');
                }
            }else {
                session()->setFlashdata('message', 'File Upload Error!');
                session()->setFlashdata('alert-type', 'danger');
            }

            
        }
        return view('upload_file');
    }

    protected function parseCsv($filePath) {
        $csvData = [];
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            $header = fgetcsv($handle); 

            #$header = array_map('trim', $header); 
    
            while (($data = fgetcsv($handle)) !== FALSE) 
            {
                #print_r($data);die;
                $row = [];
                // foreach ($header as $index => $key) {
                //     $row[$key] = isset($data[$index]); 
                // }
                $row['name'] = $data[0];
                $row['email'] = $data[1];
                $row['phone_number'] = $data[2];
                $row['address'] = $data[3];
                $csvData[] = $row; 
            }
            fclose($handle);
        }
        return $csvData;
    }

    private function checkForDuplicates($csvData, $checkOption)
    {
        $phones = [];
        $emails = [];
        $duplicates = [];

        foreach ($csvData as $row) 
        {
            #print_r($checkOption);die;
            $phone = isset($row['phone_number']) ? $row['phone_number'] : '';
            $email = isset($row['email']) ? $row['email'] : '';
            if(!empty($checkOption))
            {
                if (in_array('phone', $checkOption) || in_array('both', $checkOption)) {
                    $phoneExists = $this->Tickets->where('phone_number', $phone)->first();
                    if ($phoneExists) {
                        $duplicates[] = ['phone' => $phone];
                    } else {
                        $phones[] = $phone; 
                    }
                }
    
                if (in_array('email', $checkOption) || in_array('both', $checkOption)) {
                    $emailExists = $this->Tickets->where('email', $email)->first();
                    if ($emailExists) {
                        $duplicates[] = ['email' => $email];
                    } else {
                        $emails[] = $email;
                    }
                }
            }
            
        }
        #print_r($duplicates);die;
        return $duplicates;
    }


}
