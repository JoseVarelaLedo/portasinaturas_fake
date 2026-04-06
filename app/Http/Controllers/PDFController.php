<?php

namespace App\Http\Controllers;

use App\Models\Emenda;
use App\Services\SolicitudeDocumentacionService;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function index()
    {
        return view("pdf.emenda_pdf");
    }

    public function xerarPDF(Emenda $emenda, SolicitudeDocumentacionService $documentacionService)
    {
        $emenda->load([
            'solicitude.solicitante',
            'solicitude.entidade',
            'solicitude.usuarioAdministrativo',
            'solicitude.usuarioTecnico',
            'solicitude.documentacionTecnica',
            'solicitude.documentacionAdministrativa',
        ]);

        $solicitude = $emenda->solicitude;
        $documentacionVm = $documentacionService->buildForSolicitude($solicitude);

        $camposEmendar = collect(array_merge(
            array_map(function (array $campo): array {
                $campo['seccion'] = 'Técnica';
                return $campo;
            }, $documentacionVm['camposTecnicos']),
            array_map(function (array $campo): array {
                $campo['seccion'] = 'Administrativa';
                return $campo;
            }, $documentacionVm['camposAdministrativos'])
        ))
            ->filter(fn (array $campo): bool => ($campo['estado'] ?? null) === 'emendar')
            ->values()
            ->all();

        $pdf = Pdf::setOption(['defaultFont' => 'Xunta Sans'])->loadView('pdf/emenda_pdf', [
            'emenda' => $emenda,
            'solicitude' => $solicitude,
            'camposEmendar' => $camposEmendar,
            'dataEmision' => now()->format('d/m/Y'),
            'dataEmisionLonga' => $this->formatDataLongaGalego(now()),
        ]);

        return $pdf->download('emenda-' . $emenda->id . '.pdf');
    }

    private function formatDataLongaGalego(\DateTimeInterface $date): string
    {
        $meses = [
            1 => 'xaneiro',
            2 => 'febreiro',
            3 => 'marzo',
            4 => 'abril',
            5 => 'maio',
            6 => 'xuño',
            7 => 'xullo',
            8 => 'agosto',
            9 => 'setembro',
            10 => 'outubro',
            11 => 'novembro',
            12 => 'decembro',
        ];

        $mes = (int) $date->format('n');
        $dia = $date->format('j');
        $ano = $date->format('Y');

        return $dia . ' de ' . ($meses[$mes] ?? '') . ' de ' . $ano;
    }
}
