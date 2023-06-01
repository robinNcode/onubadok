<?php namespace Robinncode\Onubadok\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class OnubadokCommands extends Command
{
    protected $signature = 'onubadok:generate {language?}';
    protected $description = 'Generate Bengali and English files using onubadok command';
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
        // generate a new instance of the Filesystem class
        $base_folder = base_path('lang');

        $language = $this->argument('language');

        if ($language == null) {
            $this->error('Please provide a language code');
        }
        else{
            $folders = ['en', $language];
            $this->generating($folders, $base_folder);
        }
    }

    // generate the files in the app folder with the contents of the package files

    /**
     * @throws FileNotFoundException
     */
    protected function generating($folders, $base_folder): void
    {
        // Check if the directory already exists then override the base folder
        if (!$this->generateController()) {
            $this->error('Unable to generate the OnubadokController');
        } else {
            foreach ($folders as $language) {
                if ($this->fileSystem->exists($base_folder . '/' . $language)) {
                    $this->info('The directory already exists');
                    $this->info('Overriding the base folder');
                    $base_folder = $base_folder . '/' . $language;
                    break;
                } else {
                    // Creating app/lang/en directory and generating files
                    $this->info('Generating files in the app/lang/' . $language . ' directory ...');
                    if ($this->generateFilesWithContents($base_folder, $language)) {
                        $this->info('The files were generated successfully in the app/lang/' . $language . ' directory');
                    } else {
                        $this->error('The files were not generated');
                    }
                }
            }
        }
    }

    /**
     * @throws FileNotFoundException
     */
    public
    function generateFilesWithContents($base_folder, $language): bool
    {
        $package_folder = __DIR__ . '/../lang/' . $language . '/';
        $success = 0;

        // generate the directory
        $this->fileSystem->makeDirectory($base_folder . '/' . $language, 0755, true);

        // get all the files from the package
        $files = $this->fileSystem->files($package_folder);

        // generate the files in the app folder with the contents of the package files
        foreach ($files as $file) {
            $file_name = $file->getFilename();
            $file_contents = $this->fileSystem->get($file);

            // generate the file in the app folder
            $content_folder = $base_folder . '/' . $language;
            $content_file_name = $content_folder . '/' . $file_name;

            if ($this->fileSystem->put($content_file_name, $file_contents)) {
                $this->line('* lang/' . $language . '/' . $file_name . ' generated successfully!');
                $success++;
            }

        }

        if ($success == count($files))
            return true;
        else
            return false;
    }

    /**
     * @throws FileNotFoundException
     */
    public
    function generateController(): bool
    {
        $app_folder = app_path() . '/Http/Controllers/';
        $package_folder = __DIR__ . '/../Controllers/';

        $contents = $this->fileSystem->get($package_folder . 'OnubadokController.php');

        // generate the file
        return $this->fileSystem->put($app_folder . 'OnubadokController.php', $contents);
    }
}
