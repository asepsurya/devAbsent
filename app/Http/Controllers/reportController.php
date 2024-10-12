<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\absent;
use App\Models\gtk;
use App\Models\student;

class reportController extends Controller
{
    public function reportAbsensiAll(Request $request)
    {
        $allDates = absent::select('tanggal')
        ->groupBy('tanggal')
        ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') ASC")
        ->pluck('tanggal')
        ->map(fn($date) => Carbon::createFromFormat('d/m/Y', $date)
        ->format('d/m/Y'));

        $allMonths = $allDates->map(function ($date) {
            return Carbon::createFromFormat('d/m/Y', $date)->translatedFormat('F');
        })->unique()->values();

        $allYears = $allDates->map(function ($date) {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y');
        })->unique()->values();

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $filteredAbsents = absent::select('id_rfid', 'id', 'tanggal', 'entry', 'out', 'status')
            ->when($bulan, function ($query, $bulan) {
                return $query->whereRaw("MONTH(STR_TO_DATE(tanggal, '%d/%m/%Y')) = ?", [$bulan]);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereRaw("YEAR(STR_TO_DATE(tanggal, '%d/%m/%Y')) = ?", [$tahun]);
            })
            ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') ASC")
            ->get()
            ->groupBy('id_rfid');

        $nama = student::select('id_rfid', 'nama')
            ->get()
            ->keyBy('id_rfid')
            ->union(gtk::select('id_rfid', 'nama')
            ->get()
            ->keyBy('id_rfid'));

        $formattedAbsents = [];

        foreach ($filteredAbsents as $id_rfid => $absentList) {
            $statusCounts = [
                'H' => 0,
                'S' => 0,
                'I' => 0,
                'A' => 0,
            ];

            foreach ($absentList as $absent) {
                $formattedAbsents[$id_rfid][] = [
                    'id'       => $absent->id,
                    'tanggal'  => $absent->tanggal,
                    'nama'     => $nama[$id_rfid]->nama ?? 'Unknown',
                    'entry'    => $absent->entry,
                    'out'      => $absent->out,
                    'status'   => $absent->status,
                ];

                $statusCounts[$absent->status]++;
            }

            $formattedAbsents[$id_rfid]['counts'] = $statusCounts;
        }

        return view('report.absents', [
        //return response()->json([
            'title' => 'Laporan Absensi',
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'absents' => $formattedAbsents,
            'allDates' => $allDates,
            'allMonths' => $allMonths,
            'allYears' => $allYears
        ]);
    }
}
