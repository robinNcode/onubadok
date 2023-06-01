<?php namespace Robinncode\Onubadok\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class ControllerPublish extends Command{

    protected $signature = 'onubadok:publish';

    protected $description = 'Generate OnubadokController into app app path and appends a route into web.php';
    private Filesystem $fileSystem;

    public function __construct()
    {
        parent::__construct();

        $this->fileSystem = new Filesystem();
    }

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        if(!$this->generateController()){
            $this->error('The controller was not generated!');
        }
        else{
            if(!$this->generateAppController())
            {
                $this->error('The AppController was not generated!');
            }
            else{
                if(!$this->generateRoute()){
                    $this->error('The route was not generated!');
                }
                else{
                    $this->info('The controller and route were generated successfully!');
                }
            }
        }
    }

    /**
     * To generate the OnubadokController ...
     * @throws FileNotFoundException
     * @return bool
     */
    public function generateController(): bool
    {
        $app_folder = app_path() . '/Http/Controllers/';
        $package_folder = __DIR__ . '/../Controllers/';

        $contents = $this->fileSystem->get($package_folder . 'OnubadokController.php');

        // generate the file
        return $this->fileSystem->put($app_folder . 'OnubadokController.php', $contents);
    }

    /**
     * To generate the route into web.php ...
     * @throws FileNotFoundException
     */
    public function generateRoute(): bool
    {
        $app_folder = base_path() . '/routes/';

        // Read the existing contents of web.php
        $existingContents = $this->fileSystem->get($app_folder . 'web.php');

        // Append new lines to the existing contents
        $newContents = $existingContents . "\n\n" . "Route::get('onubadok/change/{lang}', 'App\Http\Controllers\OnubadokController@change');";

        // Generate the updated file
        return $this->fileSystem->put($app_folder . 'web.php', $newContents);
    }

    /**
     * To generate the AppController ...
     * @throws FileNotFoundException
     */
    public function generateAppController(): bool
    {
        $app_folder = app_path() . '/Http/Controllers/';
        $package_folder = __DIR__ . '/../Controllers/';

        $contents = $this->fileSystem->get($package_folder . 'Controller.php');

        // generate the file
        return $this->fileSystem->put($app_folder . 'Controller.php', $contents);
    }

}
