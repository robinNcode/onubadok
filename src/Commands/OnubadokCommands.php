<?php namespace Robinncode\Onubadok\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class OnubadokCommands extends Command{
    protected $signature = 'onubadok:generate';
    protected $description = 'generate Bengali and English files using your custom command';
    private Filesystem $fileSystem;

    public function __construct()
    {
        parent::__construct();

        $this->fileSystem  = new Filesystem();
    }

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        // generate a new instance of the Filesystem class
        $filesystem = new Filesystem();
        $base_folder = base_path() . '/lang';


        // Check if the directory already exists
        if ($filesystem->exists($base_folder)) {
            $this->error('The directory already exists');
        }
        else{
            // Creating app/lang/en directory and generating files
            if ($this->generateFilesWithContents($base_folder, 'en')) {
                $this->info('The files were generated successfully in the app/lang/en directory');
            }
            else{
                $this->error('The files were not generated');
            }

            // Creating app/lang/bn directory and generating files

            if ($this->generateFilesWithContents($base_folder, 'bn')) {
                $this->info('The files were generated successfully in the app/lang/bn directory');
            }
            else{
                $this->error('The files were not generated');
            }
        }
    }

    /**
     * @throws FileNotFoundException
     */
    public function generateFilesWithContents($base_folder, $language): bool
    {
        $package_folder = __DIR__ . '/../lang/'.$language.'/';
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
            if($this->fileSystem->put($content_folder . '/' . $file_name, $file_contents))
                $success++;
        }

        if ($success == count($files))
            return true;
        else
            return false;
    }
}
