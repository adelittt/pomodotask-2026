<!DOCTYPE html>
<html>
<head>
    <title>Peringatan Tugas PomoTasky</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo!</h2>
    <p>Ini adalah peringatan bahwa tugas Anda <strong>"{{ $taskName }}"</strong> telah melewati batas waktu pada <strong>{{ \Carbon\Carbon::parse($deadline)->format('d F Y') }}</strong>.</p>
    <p>Segera selesaikan tugas Anda untuk menjaga produktivitas!</p>
    <br>
    <p>Salam produktif,<br>Tim PomoTasky</p>
</body>
</html>
