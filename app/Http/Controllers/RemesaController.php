<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Remesa;
use App\Models\Emenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RemesaController extends Controller
{
    public function index(): View
    {
        $remesas = Remesa::with([
            'emenda.solicitude.solicitante',
            'emenda.solicitude.usuarioAdministrativo',
            'emenda.solicitude.usuarioTecnico',
        ])->orderByDesc('id')->get();

        $remesasAgrupadas = $remesas
            ->groupBy(fn (Remesa $remesa) => $remesa->codigoGrupo())
            ->map(function (Collection $grupo): array {
                /** @var Remesa $remesaPrincipal */
                $remesaPrincipal = $grupo->sortBy('id')->first();

                $bloquesUsuarios = $grupo
                    ->groupBy(function (Remesa $remesa): string {
                        $admin = $remesa->emenda?->solicitude?->usuarioAdministrativo?->nome ?? 'Sen asignar';
                        $tecnico = $remesa->emenda?->solicitude?->usuarioTecnico?->nome ?? 'Sen asignar';

                        return $admin . '|' . $tecnico;
                    })
                    ->map(function (Collection $bloque, string $clave): array {
                        [$admin, $tecnico] = explode('|', $clave, 2);

                        return [
                            'admin' => $admin,
                            'tecnico' => $tecnico,
                            'remesas' => $bloque->sortBy('id')->values(),
                        ];
                    })
                    ->values();

                return [
                    'codigo' => $remesaPrincipal->codigoGrupo(),
                    'anchor' => $remesaPrincipal->anchorGrupo(),
                    'creadaEn' => $remesaPrincipal->created_at,
                    'remesas' => $grupo->sortBy('id')->values(),
                    'bloquesUsuarios' => $bloquesUsuarios,
                ];
            })
            ->values();

        return view("layouts._partials.remesa", compact("remesasAgrupadas"));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'emenda_ids' => ['required', 'array', 'min:1'],
            'emenda_ids.*' => ['integer', 'exists:emendas,id'],
        ]);

        $emendas = Emenda::query()
            ->with(['solicitude', 'remesaActual'])
            ->whereIn('id', $data['emenda_ids'])
            ->get();

        $emendasValidas = $emendas->filter(function (Emenda $emenda): bool {
            $solicitude = $emenda->solicitude;

            return !$emenda->remesaActual
                && $solicitude
                && $solicitude->id_usuario_admin
                && $solicitude->id_usuario_tecnico;
        })->values();

        if ($emendasValidas->isEmpty()) {
            return redirect()->route('emenda.listado')->withErrors([
                'remesa' => 'Non hai emendas validas seleccionadas para xerar unha remesa.',
            ]);
        }

        $remesaGrupo = 'REM-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));

        foreach ($emendasValidas as $emenda) {
            $solicitude = $emenda->solicitude;

            Remesa::query()->create([
                'remesa_grupo' => $remesaGrupo,
                'id_emenda' => $emenda->id,
                'id_usuario_admin' => $solicitude->id_usuario_admin,
                'id_usuario_tecnico' => $solicitude->id_usuario_tecnico,
            ]);
        }

        return redirect()->route('remesa.listado')->with('success', 'Remesa ' . $remesaGrupo . ' xerada correctamente.');
    }

}
