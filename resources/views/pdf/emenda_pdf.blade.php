<!DOCTYPE html>
<html lang="gl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style>
        *{
            font-family: "xunta-sans";
        }
        h1 {
            color: darkslategray;
        }

        p {
            text-align: justify;
            margin-bottom: 2px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 20px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px 20px;
            text-align: left;
        }

        body {
            padding-top: 60px;
            margin-top:5px;
        }


        .lista-guions {
            list-style-type: none;
            padding-left: 20px;
        }

        .lista-guions li::before {
            content: "- ";
            color: black;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        .texto_resaltado {
            font-weight: bold;
            font-style: oblique;
            color: midnightblue;
        }

        .caixa_texto {
            border: 1px solid;
            margin: 5px;
            padding: 5px;
            border-radius: 3px;
        }

        .salto_paxina {
            page-break-after: always;
        }
    </style>
</head>
<header>
    <img src="img/pdf/banner_pdf.png" alt="banner pdf" />
</header>

<body>

    <h1>Procedemento</h1>
    <div class="caixa_texto">
        <p>
            Programas 4-5 vencellados ao autoconsumo e almacenamento no sector residencial, as administracións públicas
            e o terceiro sector.
        </p>
    </div>
    <div class="caixa_texto">
        <div>
            <span class="texto_resaltado">Entidade colaboradora:</span>
            {{ $solicitude?->entidade?->nome ?? ($solicitude?->nome_entidade ?? 'Sen dato') }}
        </div>
        <div>
            <span class="texto_resaltado">Código asignado polo INEGA na adhesión:</span>
            {{ $solicitude?->entidade?->cif ?? 'Sen dato' }}
        </div>
        <div>
            <span class="texto_resaltado">Representante entidade colaboradora:</span>
            {{ $solicitude?->usuarioAdministrativo?->nome ?? 'Sen dato' }}
        </div>
        <div>
            <span class="texto_resaltado">Usuario técnico asignado:</span>
            {{ $solicitude?->usuarioTecnico?->nome ?? 'Sen dato' }}
        </div>
    </div>
    <div class="caixa_texto">
        <span class="texto_resaltado">Solicitante:</span>
        {{ $solicitude?->solicitante?->nome ?? 'Sen dato' }}<br />
        <span class="texto_resaltado">Código Solicitude:</span>
        #{{ $solicitude?->id ?? 'Sen dato' }}<br />
        <span class="texto_resaltado">Código Emenda:</span>
        #{{ $emenda?->id ?? 'Sen dato' }}<br />
        <span class="texto_resaltado">Actuación:</span>
        {{ $solicitude?->estado_solicitude ?? 'Sen indicar' }}<br />
    </div>
    <h2 class="texto_resaltado">Requerimento de Emenda da solicitude</h2>
    <p>
        Vista a solicitude presentada, acolléndose a convocatoria de axudas correspondente ós Programas 4-5 vencellados
        ao autoconsumo e ao almacenamento no sector residencial, as administracións pública e o terceiro sector, no
        marco do Plan de recuperación, transformación e resiliencia europeo , contida na Resolución do 28 de outubro de
        2021 (publicada no Diario Oficial de Galicia núm.215 do 9 de novembro de 2021), e atendendo ao disposto no
        artigo 12. 1 da convocatoria, observáronse deficiencias que é preciso corrixir para proseguir coa tramitación do
        procedemento.
        Por conseguinte, deberá <b> en formato electrónico, a través da aplicación informática</b>, para a súa
        incorporación ao expediente a seguinte documentación:
    </p>
    <ul class="lista-guions">
        @forelse ($camposEmendar as $campo)
            <li>
                <span class="texto_resaltado">{{ $campo['etiqueta'] }} ({{ $campo['seccion'] }})</span>.
                @if (!empty($campo['motivo']))
                    Motivo: {{ $campo['motivo'] }}.
                @endif
            </li>
        @empty
            <li>
                <span class="texto_resaltado">Non hai documentación marcada para emendar.</span>
            </li>
        @endforelse
    </ul>
    <div class="salto_paxina">
    </div>
    <div>
        <p>
            O prazo de que se dispón para emendar a solicitude é de <b>DEZ (10) DÍAS
                HÁBILES</b>, que se contarán a partir do día
            seguinte a aquel en que teña lugar a notificación deste requirimento.
        </p>
        <p>
            Tales requirimentos de emenda, así como calquera tipo de notificación, realizarase a través de medios
            electrónicos, de conformidade co establecido no artigo 43 da Lei 39/2015, do 1 de outubro, de procedemento
            administrativo común das administracións públicas, <u>de maneira que, cando existindo constancia da posta a
                disposición da notificación, transcorresen 10 días naturais sen que se acceda a o seu contido,
                entenderase que a
                notificación foi REXEITADA</u>, cos efectos previstos no artigo 68.1 da Lei 39/2015, do 1 de outubro, do
            procedemento administrativo común das administracións públicas, salvo que de oficio ou por instancia do
            destinatario se comprobe a imposibilidade técnica ou material de acceso.
        </p>
        <p>
            A documentación á que se refire a emenda presentarase a través da aplicación informática do Inega dispoñible
            desde a páxina web do Inega (http//:www.inega.gal) ou accesible desde a sede electrónica da Xunta de Galicia
            (http://sede.xunta.gal).
        </p>
        Se non se atende a este requirimento no prazo indicado, ou se a emenda resulta incompleta ou defectuosa,
        <span class="texto_resaltado">entenderase que DESISTE DA SÚA SOLICITUDE</span>, procedéndose a ditar
        resolución en tal sentido.
        </p>
        <p>
            Santiago de Compostela, {{ $dataEmisionLonga ?? ($dataEmision ?? now()->format('d/m/Y')) }}
        </p>
        <p>
            A Xerente,
        </p>
        <p>
            Silvia Cortiñas Fernández
        </p>
    </div>
</body>
<footer>
    <img src="img/pdf/footer_pdf.png" alt="footer pdf" />
</footer>

</html>
