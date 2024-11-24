<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST" ) {
    exit("POST request method required");
}

if (empty($_FILES)) {
    exit('$_FILES is empty - is file uploads enabled in php.ini?');
}

if($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    switch ($_FILES["image"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            exit("File Partially Uploaded");
            break;

        case UPLOAD_ERR_NO_FILE:
            exit("No file was uploaded");
            break;

        case UPLOAD_ERR_EXTENSION:
            exit("FILE upload stopped by php extension");
            break;

        // case UPLOAD_ERR_FORM_SIZE:
        //     exit("File exceeded limit");
        //     break;

        case UPLOAD_ERR_INI_SIZE: 
            exit("FIle exceeds upload_max_filesize in php.ini");
            break;
        default: 
            exit("Unknown upload error");
            break;
    }
}
print_r($_FILES);
?>
<br>
<!-- <a download="<?php $file_name; ?>" href="uploads/<?php echo $file_name; ?>"><?php echo $file_name; ?></a> -->