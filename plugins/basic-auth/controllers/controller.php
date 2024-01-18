<?php

$files = $req->upload_files();

dd($req->upload_errors);
dd('Uploaded files: '. implode("<br>", $files));