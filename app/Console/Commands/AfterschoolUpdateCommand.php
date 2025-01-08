<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Afterschools;
use App\Models\Activity;
use App\Models\Cities;
use App\Models\States;

class AfterschoolUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:afterschool-update {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (($handle = fopen(base_path('/datafiles/afterschool/afterschoolprograms' . $this->argument('number') . '.csv'), 'r')) !== false) {
            $row = 0;
            
            while (($data = fgetcsv($handle, 2000, ';')) !== false) {
                $row++;

                if ($row == 1) {
                    continue;
                }

                $afterschool = Afterschools::where('name', $data[0])
                                            ->where('zip', $data[6])
                                            ->first();

                if ($afterschool) {
                    $this->info("exists = " . $data[0]);
                    continue;
                }

                $this->info("create new row " . $row . " " . $data[0]);

                $push_data = [];
                $push_data['name'] = substr($data[0], 0, 90);
                $push_data['location'] = $data[1];
                $push_data['address'] = $data[2];
                $push_data['address2'] = $data[3];
                $push_data['city'] = $data[4];
                $push_data['state'] = $data[5];
                $push_data['zip'] = $data[6];
                $push_data['phone'] = $data[7];
                $push_data['phone_ext'] = $data[8];
                $push_data['county'] = $data[9];
                $push_data['email'] = $data[10];
                $push_data['contact_firstname'] = $data[13];
                $push_data['contact_lastname'] = $data[14];
                $push_data['age_range'] = $data[15];
                $push_data['transportation'] = $data[16];
                $push_data['website'] = $data[17];
                $push_data['accreditation'] = $data[18];
                $push_data['daysopen'] = $data[19];
                $push_data['hoursopen'] = $data[20];
                $push_data['introduction'] = $data[23];
                $push_data['additionalInfo'] = $data[24];
                $push_data['pricing'] = $data[25];
                if ($data[26]=="YES") {
                    $push_data['is_afterschool'] = 1;
                }
                if ($data[27]=="YES") {
                    $push_data['is_camp'] = 1;
                }
                $push_data['logo'] = $data[28];
                $push_data['schools_served'] = $data[29];
                $push_data['approved'] = 1;
                $push_data['created'] = date('Y-m-d h:i:s');
                $push_data['updated'] = date('Y-m-d h:i:s');

                $name = str_replace(["  "," ","-","(",")","/","@","+","&"],"_",$push_data['name']);
                $name = str_replace([":",".","'",",","#","\"","’"],"",$name);
                $name = substr($name,0,65);
                
                $push_data['filename'] = strtolower($name);
                $push_data['filename'] = str_replace(["'","&"],"",$push_data['filename']);
                $push_data['filename'] = str_replace(["___","__","-","(",")","/","@","+"],"_",$push_data['filename']);
                
                $city = Cities::where('state', $push_data['state'])
                                ->where('city', $push_data['city'])
                                ->first();
                
                if ($city) {
                    $push_data['cityfile'] = $city->filename;
                    $push_data['county'] = $city->county;
                }

                $push_data['capacity'] = 0;
                $push_data['status'] = 0;
                $push_data['type'] = '';
                $push_data['visits'] = 0;
                $push_data['state_rating'] = '';
                $push_data['subsidized'] = 0;
                $push_data['typeofcare'] = '';
                $push_data['language'] = '';

                $afterschool = Afterschools::create($push_data);
            }

            fclose($handle);
        }
        else{
            $this->info('Unable to open a data file');
        }
    }
}
