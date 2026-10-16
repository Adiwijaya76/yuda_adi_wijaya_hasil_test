<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait RespondsWithDataTables
{
    /**
     * Bangun response JSON sesuai format DataTables (server-side).
     *
     * @param  Builder|Relation  $baseQuery  Query dasar (scoped, tanpa filter pencarian).
     * @param  callable  $mapRow  fn($row): array — memetakan baris ke kolom.
     * @param  callable|null  $applyFilters  fn($query): void — menerapkan filter pencarian.
     */
    protected function dataTablesResponse(
        Builder|Relation $baseQuery,
        Request $request,
        callable $mapRow,
        ?callable $applyFilters = null,
    ): JsonResponse {
        $recordsTotal = (clone $baseQuery)->count();

        $query = clone $baseQuery;

        if ($applyFilters) {
            $applyFilters($query);
        }

        $recordsFiltered = (clone $query)->count();

        $draw = (int) $request->input('draw', 1);
        $start = max((int) $request->input('start', 0), 0);
        $length = (int) $request->input('length', 10);
        $length = $length > 0 ? min($length, 100) : 10;

        $rows = $query->skip($start)->take($length)->get()->values();

        $data = $rows->map(function ($row, int $index) use ($mapRow, $start) {
            $mapped = $mapRow($row);
            $mapped['DT_RowIndex'] = $start + $index + 1;

            return $mapped;
        })->all();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
