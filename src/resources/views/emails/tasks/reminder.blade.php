<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Tugas PomoTasky</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo!</h2>
    <p>Ini adalah pengingat bahwa tugas Anda <strong>"{{ $taskName }}"</strong> akan jatuh tempo pada <strong>{{ \Carbon\Carbon::parse($deadline)->format('d F Y') }}</strong> (Besok).</p>
    <p>Jangan lupa untuk menyelesaikannya tepat waktu!</p>
    <br>
    <p>Salam produktif,<br>Tim PomoTasky</p>
</body>
</html>
