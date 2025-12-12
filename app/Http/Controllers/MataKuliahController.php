<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Http\Resources\MatakuliahResource;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = MataKuliah::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Matakuliah',
            'data' => MatakuliahResource::collection($matakuliahs)
        ], 200);
    }

    public function show($id)
    {
        $matakuliah = MataKuliah::find($id);
        
        if (!$matakuliah) {
            return response()->json([
                'success' => false,
                'message' => 'Data Matakuliah tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Matakuliah',
            'data' => new MatakuliahResource($matakuliah)
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_matakuliah' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $matakuliah = MataKuliah::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Matakuliah berhasil disimpan',
            'data' => new MatakuliahResource($matakuliah)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::find($id);
        
        if (!$matakuliah) {
            return response()->json([
                'success' => false,
                'message' => 'Data Matakuliah tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_matakuliah' => 'sometimes|required|string|max:255',
            'sks' => 'sometimes|required|integer|min:1',
            'semester' => 'sometimes|required|integer|min:1|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $matakuliah->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Matakuliah berhasil diubah',
            'data' => new MatakuliahResource($matakuliah)
        ], 200);
    }

    public function destroy($id)
    {
        $matakuliah = MataKuliah::find($id);
        
        if (!$matakuliah) {
            return response()->json([
                'success' => false,
                'message' => 'Data Matakuliah tidak ditemukan'
            ], 404);
        }

        $matakuliah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Matakuliah berhasil dihapus'
        ], 200);
    }
}

