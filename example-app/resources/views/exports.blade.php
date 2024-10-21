<!DOCTYPE html>
<html>
<head>
    <title>Your Export is Ready</title>
</head>
<body>
    <h1>Your Export is Ready</h1>
    <p>Your export file is ready for download:</p>
    <a href="{{ url('/download-export/' . $fileName) }}">Download Here</a>
</body>
</html>