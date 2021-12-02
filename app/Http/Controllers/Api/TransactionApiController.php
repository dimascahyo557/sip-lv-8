<?php

namespace App\Http\Controllers\Api;

use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use App\Imports\TransactionImport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionApiController extends Controller
{
    /**
     *  @OA\Get(
     *      path="/api/transaction",
     *      summary="Get all transaction",
     *      description="get all transaction",
     *      tags={"Sales"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      operationId="all-transaction",
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anouthorized",
     *      ),
     *  )
     */
    public function index()
    {
        $transactions = Transaction::all();

        return response()->json([
            'success' => true,
            'message' => 'Get data success',
            'data' => $transactions,
        ]);
    }

    /**
     *  @OA\Post(
     *      path="/api/transaction/import",
     *      summary="Import transaction",
     *      description="import transaction",
     *      tags={"Sales"},
     *      security={
     *          {"api_key": {}},
     *      },
     *      operationId="import-transaction",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="import",
     *                      description="Import excel",
     *                      type="file",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Anouthorized",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *      ),
     *  )
     */
    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import( new TransactionImport, $request->file('import') );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import data failed',
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Import data success',
            'data' => null,
        ]);
    }
}
