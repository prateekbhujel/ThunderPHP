<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple OCR</title>
</head>
<body>
    <h1>Simple OCR</h1>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <button type="submit" name="submit">Upload & OCR</button>
    </form>
</body>
</html>
