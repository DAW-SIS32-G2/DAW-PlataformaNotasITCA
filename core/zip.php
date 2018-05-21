<?php
function comprimir($folder)
{
  // Get real path for our folder
  $rootPath = realpath($folder);
  echo $rootPath;
  // Initialize archive object
  $zip = new ZipArchive();
  $archivo = 'Practicas/temp/practicas.zip';
  $zip->open($archivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

  // Create recursive directory iterator
  /** @var SplFileInfo[] $files */
  $files = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($rootPath),
      RecursiveIteratorIterator::LEAVES_ONLY
  );

  foreach ($files as $name => $file)
  {
      // Skip directories (they would be added automatically)
      if (!$file->isDir())
      {
          // Get real and relative path for current file
          $filePath = $file->getRealPath();
          $relativePath = substr($filePath, strlen($rootPath) + 1);

          // Add current file to archive
          $zip->addFile($filePath, $relativePath);
      }
  }

  // Zip archive will be created only after closing object
  $zip->close();
  return $archivo;
}
/**
     * Download file
     *
     * @param string $path
     * @param string $type
     * @param string $name
     * @param bool $force_download
     * @return bool
     */
function download($path, $name = '', $type = 'application/octet-stream', $force_download = true) {

    if (!is_file($path) || connection_status() !== 0);

    if($force_download) {
        header("Cache-Control: public");
    } else {
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Content-Type: $type");
    header("Content-Length: ".(string)(filesize($path)));

    $disposition = $force_download ? 'attachment' : 'inline';

    if(trim($name) == '') {
        header("Content-Disposition: $disposition; filename=" . basename($path));
    } else {
        header("Content-Disposition: $disposition; filename=\"" . trim($name)."\"");
    }

    header("Content-Transfer-Encoding: binary\n");

    if ($file = fopen($path, 'rb')) {
        while(!feof($file) and (connection_status()==0)) {
            print(fread($file, 1024*8));
            flush();
        }
        fclose($file);
    }

    return((connection_status() == 0) && !connection_aborted());
} 
?>