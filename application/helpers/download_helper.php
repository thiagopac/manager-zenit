<?php 
// Read a file and display its content chunk by chunk
            function readfile_chunked($filename, $retbytes = true)
            {
                set_time_limit(0);
                ini_set('memory_limit', '1024M');
                define('CHUNK_SIZE', 1024 * 1024); // Size (in bytes) of tiles chunk

                $buffer = '';
                $cnt = 0;
                $handle = fopen($filename, 'rb');

                if ($handle === false) {
                    return false;
                }

                while (!feof($handle)) {
                    $buffer = fread($handle, CHUNK_SIZE);
                    echo $buffer;
                    ob_flush();
                    flush();

                    if ($retbytes) {
                        $cnt += strlen($buffer);
                    }
                }

                $status = fclose($handle);

                if ($retbytes && $status) {
                    return $cnt; // return num. bytes delivered like readfile() does.
                }

                return $status;
            }

function stream_file($filename, $savename)
{
    $file = './files/media/' . $savename;
    $mime = get_mime_by_extension($file);

    $mime_to_display = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/bmp'];
    $stream_type = (in_array($mime, $mime_to_display)) ? 'inline' : 'attachment';

    if (file_exists($file)) {
        header('Content-Type: ' . $mime);
        header('Content-Disposition: ' . $stream_type . '; filename=' . basename($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        //ob_clean();
        flush();
        readfile($file);

        exit;
    }
}
