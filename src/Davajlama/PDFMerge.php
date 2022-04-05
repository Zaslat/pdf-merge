<?php

declare(strict_types=1);

namespace Davajlama;

if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
    define('K_TCPDF_EXTERNAL_CONFIG', true);

    require_once __DIR__ . '/config/config.php';
}

use TCPDI\TCPDI;

final class PDFMerge
{
    public const OUTPUT_DOWNLOAD = 'download';
    public const OUTPUT_BROWSER = 'browser';
    public const OUTPUT_STRING = 'string';
    public const OUTPUT_FILE = 'file';

    /**
     * @var string[]
     */
    private array $sources = [];

    public function addFile(string $filePath): self
    {
        if (!file_exists($filePath)) {
            throw new \Exception(sprintf('File [%s] not exists.', $filePath));
        }

        $this->addContent(file_get_contents($filePath));

        return $this;
    }

    public function addContent(string $content): self
    {
        $this->sources[] = $content;

        return $this;
    }

    public function merge(string $output = self::OUTPUT_BROWSER, string $filename = 'example.pdf'): mixed
    {
        $pdf = new TCPDI();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        foreach ($this->sources as $source) {
            $pagesCount = $pdf->setSourceData($source);

            for ($page = 1; $page <= $pagesCount; $page++) {
                $template = $pdf->importPage($page);
                $size = $pdf->getTemplateSize($template);
                $orientation = ($size['h'] > $size['w']) ? 'P' : 'L';

                $pdf->AddPage($orientation, [$size['w'], $size['h']]);
                $pdf->useTemplate($template);
            }
        }

        switch($output) {
            case self::OUTPUT_FILE:
                $pdf->Output($filename, 'F');
                break;
            case self::OUTPUT_DOWNLOAD:
                $pdf->Output($filename, 'D');
                break;
            case self::OUTPUT_STRING:
                return $pdf->Output($filename, 'S');
            case self::OUTPUT_BROWSER:
            default:
                $pdf->Output($filename, 'I');
        }

        return null;
    }
}
