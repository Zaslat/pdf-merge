PDFMerge
=====

PDFMerge based on [TCPDI](https://github.com/pauln/tcpdi) and [TCPDF](https://github.com/tecnickcom/TCPDF). Supports PDFs up to v1.7.

Installation
------------
The recommended way to install PDFMerge is via Composer
```
composer require davajlama/pdf-merge
```
PDFMerge requires PHP version > 8.0

Usage
-----
```php
use Davajlama\PDFMerge;

$pdfMerge = new PDFMerge();
$pdfMerge->addFile('file01.pdf');
$pdfMerge->addFile('file02.pdf');
$pdfMerge->merge(PDFMerge::OUTPUT_BROWSER, 'merged.pdf');
```
