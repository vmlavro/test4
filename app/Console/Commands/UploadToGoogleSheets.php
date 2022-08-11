<?php

namespace App\Console\Commands;

use App\Services\Factory\ReaderFactory;
use App\Services\Reader\ReaderInterface;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use App\Services\MatrixConverter;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;
use Revolution\Google\Sheets\Facades\Sheets;

class UploadToGoogleSheets extends Command
{
    const MATRIX_CHUNK_SIZE = 3000;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'googleSheets:upload {--source=} {--localPath=} {--ftpServer=} {--ftpPath=} {--ftpUser=} {--ftpPassword=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command uploads given XML (local or ftp) to a google sheets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        ReaderFactory $readerFactory,
        Logger $logger,
        MatrixConverter $converter
    )
    {
        try {
            $reader = $readerFactory->getReader($this->input);
            $content = $reader->getContent();

            // Let's give a chance that in the future we could operate more than one format.
            $matrix = $converter->fromXml($content);

            // To avoid memory crash
            $matrixChunks = array_chunk($matrix, self::MATRIX_CHUNK_SIZE);
            $spreadSheet = Sheets::spreadsheet(config('google.sheets.spreadsheet_id'));
            $sheetName = current($spreadSheet->sheetList());
            $spreadSheet->sheet($sheetName)->clear();
            $appendRow = 1;
            foreach ($matrixChunks as $chunk) {
                $spreadSheet->sheet($sheetName)->range('A' . $appendRow)->append($chunk);
                $appendRow += self::MATRIX_CHUNK_SIZE;
            }
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            $logger->error(
                $exception->getMessage(),
                [
                    'input' => $this->input->getOptions(),
                    'spreadSheet' => config('google.sheets.spreadsheet_id'),
                ]
            );
        }

        return 0;
    }
}
