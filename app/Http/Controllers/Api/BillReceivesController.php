<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Criteria\FindBetweenDateBRCriteria;
use CodeFin\Criteria\FindValueBRCriteria;
use CodeFin\Http\Controllers\Controller;
use CodeFin\Repositories\BillReceivesRepository;
use CodeFin\Http\Requests\BillReceiveRequest;
use Illuminate\Http\Request;

use CodeFin\Http\Requests;

class BillReceivesController extends Controller
{
    /**
     * @var BillReceivesRepository
     */
    protected $repository;

    public function __construct(BillReceivesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParam = config('repository.criteria.params.search');
        $search = $request->get($searchParam);
        $this->repository
            ->pushCriteria(new FindBetweenDateBRCriteria($search))
            ->pushCriteria(new FindValueBRCriteria($search));
        $billReceives = $this->repository->paginate(3);

        return $billReceives;
    }

    /**
     * Store a newly created resource in storage
     *
     * @param BillReceiveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillReceiveRequest $request)
    {
        $billReceive = $this->repository->create($request->all());
        return response()->json($billReceive, 201);
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
        $billReceive = $this->repository->find($id);

        return response()->json($billReceive);
    }

    /**
     * Update the specified resource in storage
     *
     * @param BillReceiveRequest $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillReceiveRequest $request, $id)
    {
        $billReceive = $this->repository->update($request->all(), $id);
        return response()->json($billReceive);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);

        return response()->json([], 204);
    }

}
