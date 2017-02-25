<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Http\Controllers\Controller;
use CodeFin\Repositories\BillPayRepository;
use CodeFin\Http\Requests\BillPayRequest;
use Illuminate\Http\Request;

use CodeFin\Http\Requests;

class BillPaysController extends Controller
{
    /**
     * @var BillPayRepository
     */
    protected $repository;

    public function __construct(BillPayRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billPays = $this->repository->paginate();

        return $billPays;
    }

    /**
     * Store a newly created resource in storage
     *
     * @param BillPayRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillPayRequest $request)
    {
        $billPay = $this->repository->create($request->all());
        return response()->json($billPay, 201);
    }

    /**
     * Display the specified resource
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billPay = $this->repository->find($id);

        return response()->json($billPay);
    }

    /**
     * Update the specified resource in storage
     *
     * @param BillPayRequest $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillPayRequest $request, $id)
    {
        $billPay = $this->repository->update($request->all(), $id);
        return response()->json($billPay);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);

        return response()->json([], 204);
    }

}
