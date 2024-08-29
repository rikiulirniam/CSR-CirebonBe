<!DOCTYPE html>
<html>
<head>
    <title>Verification Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <a href="http://localhost:5173/mitra/login" class="btn text-white" style="background-color: #98100A">Kembali ke halaman Login</a>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

    </div>
</body>
</html>
