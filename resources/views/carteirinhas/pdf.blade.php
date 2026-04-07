<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Carteirinha</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
            font-family: 'Trebuchet MS', Arial, sans-serif;
            color: #264768;
            background: #fff;
        }

        .sheet {
            width: 210mm;
            height: 297mm;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            position: relative;
            width: 85.60mm;
            height: 52.68mm;
            overflow: hidden;
            background-image: url('data:image/png;base64,{{ $backgroundImage }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            page-break-inside: avoid;
        }

        .name-bar {
            position: absolute;
            top: 27.5%;
            left: 48.85%;
            width: 46.8%;
            min-height: 15.5%;
            padding: 2.2mm 2.8mm;
            border-radius: 1.1mm;
            background: #213f5f;
            color: #fff;
            font-size: 2.6mm;
            line-height: 1.2;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .details {
            position: absolute;
            top: 62.5%;
            left: 67.4%;
            width: 26.9%;
            font-size: 2mm;
            line-height: 1.35;
            text-align: left;
        }

        .details-line {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="card">
            <div class="name-bar">{{ $carteirinha->nome }}</div>

            <div class="details">
                <p class="details-line">Associado {{ $carteirinha->categoria }}</p>
                <p class="details-line">Afiliacao {{ $carteirinha->afiliacao }}</p>
                <p class="details-line">cod: {{ $carteirinha->id }}</p>
            </div>
        </div>
    </div>
</body>
</html>
