<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateshopRequest;
use App\Http\Requests\Backend\UpdateshopRequest;
use App\Repositories\Backend\shopRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class shopController extends AppBaseController
{
    /** @var  shopRepository */
    private $shopRepository;

    public function __construct(shopRepository $shopRepo)
    {
        $this->shopRepository = $shopRepo;
    }

    /**
     * Display a listing of the shop.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shopRepository->pushCriteria(new RequestCriteria($request));
        $shops = $this->shopRepository->all();

        return view('backend.shops.index')
            ->with('shops', $shops);
    }

    /**
     * Show the form for creating a new shop.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.shops.create');
    }

    /**
     * Store a newly created shop in storage.
     *
     * @param CreateshopRequest $request
     *
     * @return Response
     */
    public function store(CreateshopRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('icon')) {

            $icon = $request->icon;
            $input['icon'] = $this->shopRepository->uploadImage($icon);

        }else{
            $input['icon']="";
        }

        $shop = $this->shopRepository->create($input);

        Flash::success('Shop saved successfully.');

        return redirect(route('backend.shops.index'));
    }

    /**
     * Display the specified shop.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('backend.shops.index'));
        }

        return view('backend.shops.show')->with('shop', $shop);
    }

    /**
     * Show the form for editing the specified shop.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('backend.shops.index'));
        }

        return view('backend.shops.edit')->with('shop', $shop);
    }

    /**
     * Update the specified shop in storage.
     *
     * @param  int              $id
     * @param UpdateshopRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateshopRequest $request)
    {
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('backend.shops.index'));
        }

        $input = $request->all();
        if ($request->hasFile('icon')) {

            $icon = $request->icon;
            $input['icon'] = $this->shopRepository->uploadImage($icon);

        }else{
            $input['icon']="";
        }

        $shop = $this->shopRepository->update($input, $id);
        Flash::success('Shop updated successfully.');

        return redirect(route('backend.shops.index'));
    }

    /**
     * Remove the specified shop from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shop = $this->shopRepository->findWithoutFail($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('backend.shops.index'));
        }

        $this->shopRepository->delete($id);

        Flash::success('Shop deleted successfully.');

        return redirect(route('backend.shops.index'));
    }
}
