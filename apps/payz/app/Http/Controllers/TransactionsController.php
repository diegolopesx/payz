<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionsController extends Controller
{
    private $transactionsService;

    public function __construct(TransactionsService $transactionsService)
    {
        $this->transactionsService = $transactionsService;
        $this->middleware('auth');
    }

    /**
     * Cria uma nova transaction.
     *
     * @param   Request  $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */

    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'value' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payer' => 'required|different:payee|exists:users,id',
            'payee' => 'required|different:payer|exists:users,id',
        ]);
        $transaction        = new Transaction();
        $transaction->value = $request->input('value');
        $transaction->payer = $request->input('payer');
        $transaction->payee = $request->input('payee');
        $payer              = User::where('id', $transaction->payer)
            ->first();
        $payee              = User::where('id', $transaction->payee)
            ->first();

        if ($payer->group == 1) {
            return response()->json(DB::transaction(function () use (
                $request,
                $transaction
            ) {
                $notification = new NotificationsController();
                $notification->push($request);
                $return = $this->transactionsService->authorize($request);
                $transaction->save();
                return json_decode($return->getContent());
            }));
        }
        return response()->json(['message' => 'Você não pode realizar essa ação.']);
    }

    /**
     * Lista todas transactions.
     *
     * @param   Request  $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */

    public function index(): JsonResponse
    {
        $transactions = Transaction::with('payer','payee')
            ->where('payer', auth()->user()->id)
            ->orWhere('payee', auth()->user()->id)
            ->paginate(30);
        return response()->json($transactions);
    }
}
