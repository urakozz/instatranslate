<?php namespace App\Console\Commands;

use Aws\Common\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Illuminate\Console\Command;
use League\Flysystem\AwsS3v2\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AssetsS3Publish extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'assets:s3publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $client = S3Client::factory([
            'key' => env('AWS_CLIENT_ID'),
            'secret' => env('AWS_CLIENT_SECRET'),
            'region' => "eu-west-1"
        ]);

        $this->filesystem = new Filesystem(new AwsS3Adapter($client, env('AWS_S3_BUCKET')));
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $directory   = implode("/", ["configs", $this->option('branch'), $this->option('commit')]);
        $refManifest = new \SplFileObject(__DIR__ . "/../../../public/build/rev-manifest.json");
        $fileNameS3  = implode("/", [$directory, $refManifest->getFilename()]);
        $this->filesystem->createDir($directory);
        $this->filesystem->has($fileNameS3) && $this->filesystem->delete($fileNameS3);
        $json = file_get_contents($refManifest->getPathname());
        $this->filesystem->write($fileNameS3, $json);
        $prefixLocal = $refManifest->getPath();
        $prefixS3    = "assets/build";
        $files       = json_decode($json, true);
        foreach ($files as $file) {
            $fileLocal = $prefixLocal . '/' . $file;
            $fileS3    = $prefixS3 . "/" . $file;
            $this->filesystem->writeStream($fileS3, fopen($fileLocal, 'r'));
        }

//        $this->filesystem->createDir('data.txt', 'Hello!', array('ACL' => S3::ACL_PUBLIC_READ));


    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
//			['commit', InputArgument::REQUIRED, 'Commit id'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['branch', null, InputOption::VALUE_OPTIONAL, 'Branch', "master"],
            ['commit', null, InputOption::VALUE_REQUIRED, 'Commit id', null],
        ];
    }

}
