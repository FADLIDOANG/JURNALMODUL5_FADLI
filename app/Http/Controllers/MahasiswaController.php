<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Mahasiswa',
            'data' => MahasiswaResource::collection($mahasiswas)
        ], 200);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data Mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Mahasiswa',
            'data' => new MahasiswaResource($mahasiswa)
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas',
            'email' => 'required|string|email|unique:mahasiswas',
            'jurusan' => 'nullable|string',
            'semester' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa berhasil disimpan',
            'data' => new MahasiswaResource($mahasiswa)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data Mahasiswa tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'nim' => 'sometimes|required|string|unique:mahasiswas,nim,' . $id,
            'email' => 'sometimes|required|string|email|unique:mahasiswas,email,' . $id,
            'jurusan' => 'nullable|string',
            'semester' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mahasiswa->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa berhasil diubah',
            'data' => new MahasiswaResource($mahasiswa)
        ], 200);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data Mahasiswa tidak ditemukan'
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa berhasil dihapus'
        ], 200);
    }
}

