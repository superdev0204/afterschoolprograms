<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\States;
use App\Models\Afterschools;
use App\Models\Activity;
use App\Models\Cities;
use App\Models\Counties;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $linkCount = 0;

        $xml = new \XMLWriter();

        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xml->writeAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

        $uris = ['/', '/about'];

        foreach ($uris as $uri) {
            $linkCount++;

            $xml->startElement('url');
            $xml->writeElement('loc', 'https://' . env('DOMAIN') . $uri);
            $xml->endElement();
        }

        $states = States::all();
        
        foreach ($states as $state) {
            $linkCount++;

            $xml->startElement('url');
            $location = 'https://' . env('DOMAIN') . '/' . $state->statefile . '_activities.html';

            $xml->writeElement('loc', $location);
            $xml->endElement();

            $linkCount++;

            $xml->startElement('url');
            $location = 'https://' . env('DOMAIN') . '/' . $state->statefile . '_martial-arts.html';

            $xml->writeElement('loc', $location);
            $xml->endElement();

            $xml->startElement('url');
            $location = 'https://' . env('DOMAIN') . '/' . $state->statefile . '_youth-sports.html';

            $xml->writeElement('loc', $location);
            $xml->endElement();
        }



        $citiesCount = Cities::where("afterschool_count", ">", 0)
                            ->orWhere("activities_count", ">", 0)
                            ->orWhere("sports_count", ">", 0)
                            ->count();
        
        $offset = 0;
        $limit = 1000;

        while ($offset < $citiesCount) {
            $cities = Cities::where("afterschool_count", ">", 0)
                            ->orWhere("activities_count", ">", 0)
                            ->orWhere("sports_count", ">", 0)
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            
            foreach ($cities as $city) {
                if ($city->afterschool_count > 0) {
                    $linkCount++;

                    $xml->startElement('url');
                    $location = 'https://' . env('DOMAIN') . '/' . $city->statefile . '-city/' . $city->filename . '-care.html';

                    $xml->writeElement('loc', $location);
                    $xml->endElement();
                }

                if ($city->activities_count > 0) {
                    $linkCount++;

                    $xml->startElement('url');
                    $location = 'https://' . env('DOMAIN') . '/' . $city->statefile . '-martial-arts/' . $city->filename . '.html';

                    $xml->writeElement('loc', $location);
                    $xml->endElement();
                }

                if ($city->sports_count > 0) {
                    $linkCount++;

                    $xml->startElement('url');
                    $location = 'https://' . env('DOMAIN') . '/' . $city->statefile . '-youth-sports/' . $city->filename . '.html';

                    $xml->writeElement('loc', $location);
                    $xml->endElement();
                }
            }

            $offset += $limit;
        }

        $afterschoolCount = Afterschools::where("approved", 1)->count();
        
        $offset = 0;
        $limit = 1000;

        while ($offset < $afterschoolCount) {

            $afterschools = Afterschools::where("approved", 1)
                                        ->limit($limit)
                                        ->offset($offset)
                                        ->get();
            
            foreach ($afterschools as $afterschool) {
                $linkCount++;

                $xml->startElement('url');
                $location = 'https://' . env('DOMAIN') . '/program-' . $afterschool->id . '-' . $afterschool->filename . '.html';

                $xml->writeElement('loc', $location);
                $xml->endElement();
            }

            $offset += $limit;
        }

        $activitiesCount = Activity::where("approved", 1)->count();

        $offset = 0;
        $limit = 1000;

        while ($offset < $activitiesCount) {
            $activities = Activity::where("approved", 1)
                                ->limit($limit)
                                ->offset($offset)
                                ->get();

            foreach ($activities as $activity) {
                if ($activity->category == 'MARTIAL-ARTS') {
                    $linkCount++;

                    $xml->startElement('url');
                    $location = 'https://' . env('DOMAIN') . '/activity-' . $activity->id . '-' . $activity->filename . '.html';

                    $xml->writeElement('loc', $location);
                    $xml->endElement();
                }

                if ($activity->category == 'YOUTH-SPORTS') {
                    $linkCount++;

                    $xml->startElement('url');
                    $location = 'https://' . env('DOMAIN') . '/sportclub-' . $activity->id . '-' . $activity->filename . '.html';

                    $xml->writeElement('loc', $location);
                    $xml->endElement();
                }
            }

            $offset += $limit;
        }

        $xml->endElement();
        $xml->endDocument();

        $content = $xml->outputMemory();

        file_put_contents(public_path() . '/sitemap.xml', $content);

        $this->info('Sitemap has been generated. Link count = ' . $linkCount);
    }
}
