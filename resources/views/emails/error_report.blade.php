<!DOCTYPE html>
<html>
<head>
    <title>Error Report</title>
</head>
<body>
    <h1>An Error Occurred in Your Application</h1>
    <p><strong>Exception:</strong> {{ $exception->getMessage() }}</p>
    <p><strong>File:</strong> {{ $exception->getFile() }}</p>
    <p><strong>Line:</strong> {{ $exception->getLine() }}</p>
    <p><strong>Trace:</strong> <pre>{{ $exception->getTraceAsString() }}</pre></p>
</body>
</html>
