<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Carteirinha</title>
    <style>
        /* Configuração de página para DomPDF */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Trebuchet MS', Arial, sans-serif;
            background-color: #ffffff;
        }

        /* Container para centralizar a carteirinha na folha A4 */
        .sheet {
            position: relative;
            width: 210mm;
            height: 297mm;
        }

        /* A carteirinha em si */
        .card {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 85.60mm;
            height: 52.68mm;
            margin-top: -26.34mm; /* Metade da altura */
            margin-left: -42.80mm; /* Metade da largura */
            overflow: hidden;
        }

        /* Imagem de fundo tratada como elemento absoluto para garantir carregamento */
        .background-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 85.60mm;
            height: 52.68mm;
            z-index: -1;
        }

        /* Barra de nome - Substituindo Flex por Table-Cell para centralizar texto */
        .name-bar {
            position: absolute;
            top: 27.5%;
            left: 48.85%;
            width: 46.8%;
            height: 15.5%;
            background: #213f5f;
            color: #ffffff;
            border-radius: 1.1mm;
            text-align: center;
        }

        .name-text {
            display: table;
            width: 100%;
            height: 100%;
        }

        .name-inner {
            display: table-cell;
            vertical-align: middle;
            font-size: 2.6mm;
            line-height: 1.2;
            padding: 0 2mm;
        }

        /* Detalhes */
        .details {
            position: absolute;
            top: 62.5%;
            left: 67.4%;
            width: 26.9%;
            font-size: 2mm;
            line-height: 1.35;
            color: #264768;
            text-align: left;
        }

        .details-line {
            margin: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="card">
            <img class="background-img" src="{{ $backgroundImage }}" />

            <div class="name-bar">
                <div class="name-text">
                    <div class="name-inner">
                        {{ mb_strtoupper($carteirinha->nome) }}
                    </div>
                </div>
            </div>

            <div class="details">
                <p class="details-line">Associado {{ $carteirinha->categoria }}</p>
                <p class="details-line">Afiliação {{ $carteirinha->afiliacao }}</p>
                <p class="details-line">Cod: {{ $carteirinha->id }}</p>
            </div>
        </div>
    </div>
</body>
</html>
