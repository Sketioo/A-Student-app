<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function nilaiRT()
    {
        $results = DB::table('scores')
            ->select('nama', 'nisn', DB::raw("
                MAX(CASE WHEN nama_pelajaran = 'REALISTIC' THEN skor ELSE 0 END) as realistic,
                MAX(CASE WHEN nama_pelajaran = 'INVESTIGATIVE' THEN skor ELSE 0 END) as investigative,
                MAX(CASE WHEN nama_pelajaran = 'ARTISTIC' THEN skor ELSE 0 END) as artistic,
                MAX(CASE WHEN nama_pelajaran = 'SOCIAL' THEN skor ELSE 0 END) as social,
                MAX(CASE WHEN nama_pelajaran = 'ENTERPRISING' THEN skor ELSE 0 END) as enterprising,
                MAX(CASE WHEN nama_pelajaran = 'CONVENTIONAL' THEN skor ELSE 0 END) as conventional
            "))
            ->where('materi_uji_id', 7)
            ->where('nama_pelajaran', '!=', 'pelajaran_khusus')
            ->groupBy('nama', 'nisn')
            ->get();

        $formattedResults = $results->map(function ($result) {
            return [
                'nama' => $result->nama,
                'nisn' => $result->nisn,
                'nilaiRt' => [
                    'realistic' => $result->realistic,
                    'investigative' => $result->investigative,
                    'artistic' => $result->artistic,
                    'social' => $result->social,
                    'enterprising' => $result->enterprising,
                    'conventional' => $result->conventional,
                ],
            ];
        });

        return response()->json($formattedResults);
    }

    public function nilaiST()
    {
        $results = DB::table('scores')
            ->select('nama', 'nisn', DB::raw("
            SUM(CASE WHEN pelajaran_id = 44 THEN skor * 41.67 ELSE 0 END) as verbal,
            SUM(CASE WHEN pelajaran_id = 45 THEN skor * 29.67 ELSE 0 END) as kuantitatif,
            SUM(CASE WHEN pelajaran_id = 46 THEN skor * 100 ELSE 0 END) as penalaran,
            SUM(CASE WHEN pelajaran_id = 47 THEN skor * 23.81 ELSE 0 END) as figural,
            SUM(
                CASE WHEN pelajaran_id = 44 THEN skor * 41.67 ELSE 0 END +
                CASE WHEN pelajaran_id = 45 THEN skor * 29.67 ELSE 0 END +
                CASE WHEN pelajaran_id = 46 THEN skor * 100 ELSE 0 END +
                CASE WHEN pelajaran_id = 47 THEN skor * 23.81 ELSE 0 END
            ) as total
        "))
            ->where('materi_uji_id', 4)
            ->groupBy('nama', 'nisn')
            ->orderByDesc('total')
            ->get();

        $formattedResults = $results->map(function ($result) {
            return [
                'nama' => $result->nama,
                'nisn' => $result->nisn,
                'listNilai' => [
                    'verbal' => $result->verbal,
                    'kuantitatif' => $result->kuantitatif,
                    'penalaran' => $result->penalaran,
                    'figural' => $result->figural,
                ],
                'total' => $result->total,
            ];
        });

        return response()->json($formattedResults);
    }

}
