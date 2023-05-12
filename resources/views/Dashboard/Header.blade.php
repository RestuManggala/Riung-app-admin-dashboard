<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/datatables.css">

    <title>{{$tittle}}</title>
</head>
<body>
    <div class="containers">
        <div class="sidebar">
            <div class="header">
                <div class="list-item">
                    <a href="{{ route('dashboard') }}">
                        <span class="description-header">Dashboard Cash Management</span>
                    </a>
                </div>
                <div class="illustration">
                    <img src="  " alt="">
                </div>
            </div>
            <div class="main-sidebar">
                <div class="list-item">
                    <a href="{{ route('dashboard') }}">
                        <img src=" {{ asset('image/Dashboard.svg') }} " alt="" class="icon">
                        <span class="description">Dashboard</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="{{ route('laporan') }}">
                        <img src=" {{ asset('image/Analytics.svg') }} " alt="" class="icon">
                        <span class="description">Input Transaksi</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="{{ route('rekening-koran') }}">
                        <img src=" {{ asset('image/Analytics.svg') }} " alt="" class="icon">
                        <span class="description">Rekening Koran</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="{{ route('posisi-saldo') }}">
                        <img src=" {{ asset('image/Analytics.svg') }} " alt="" class="icon">
                        <span class="description">Posisi Saldo</span>
                    </a>
                </div>
                @if (Auth::user()->jabatan_id == 1)
                    <div class="list-item">
                        <a href="{{ route('akun') }}">
                            <img src=" {{ asset('image/Category.svg') }} " alt="" class="icon">
                            <span class="description">Akun</span>
                        </a>
                    </div>
                @endif
                <div class="list-item">
                    <a href="{{ route('logout') }}">
                        <img src=" {{ asset('image/Team.svg') }} " alt="" class="icon">
                        <span class="description">Logout</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="main">
            <div class="illus-header">

            </div>
            <div class="main-header">
                <div id="menu-button">
                    <input type="checkbox" id="menu-checkbox">
                    <label for="menu-checkbox" id="menu-label">
                        <div class="hamburger"></div>
                    </label>
                    <h1 class="tittle">{{ $tittle }}</h1>
                </div>
                <div class="path-page">
                    <h1><span>Dashboard</span> / {{ $tittle }}</h1>
                </div>

            </div>

                @yield('container')

            <footer class="footer">
                <div>
                    Version 1.0 <strong>&copy; 2023 DASHBOARD </strong> - Riung Mitra Lestari
                </div>
            </footer>
        </div>
    </div>

<script src="js/script.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
        $(document).ready(function () {
        $('#dataTables').DataTable({
            scrollX: true,
        });
    });
</script>

</body>
</html>