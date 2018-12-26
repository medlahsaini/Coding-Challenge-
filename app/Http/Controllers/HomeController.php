<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Backend\shopRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\likedshop;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\shop;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(shopRepository $shopRepo)
    {
        $this->shopRepository = $shopRepo;
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $likedshops = DB::table('likedshops')
                                    ->select('shop_id')
                                    ->where('liked',1)
                                    ->where('user_id',Auth::user()->id)
                                    ->get();
        $data[] = 0;
        foreach($likedshops as $likedshop){
            $data[] = $likedshop->shop_id;
        }
        $shops = DB::table('shops')
                            ->whereNotIn('id',$data)
                            ->get();

        return view('home')
            ->with('shops', $shops);
    }


    /**
     * Show the liked shops.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function liked()
    {
        $likedshops = DB::table('likedshops')
                                    ->select('shop_id')
                                    ->where('liked',1)
                                    ->where('user_id',Auth::user()->id)
                                    ->get();
        $data[] = 0;
        foreach($likedshops as $likedshop){
            $data[] = $likedshop->shop_id;
        }
        $shops = DB::table('shops')
                            ->whereIn('id',$data)
                            ->get();

        return view('likedshops')
            ->with('shops', $shops);
    }

     /**
     * Store the liked shops.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function likehome($id)
    {
        $find =   DB::table('likedshops')
                            ->where('shop_id', $id)
                            ->where('user_id',Auth::user()->id)
                            ->first();
        if($find){
            $find->liked = 1;
            $find->save();
        }else{
            $likedshop = new likedshop;
            $likedshop->user_id = Auth::user()->id;
            $likedshop->shop_id = $id;
            $likedshop->liked = 1;
            $likedshop->save();

        }
        
        return redirect()->route('home');
        
        
    }

     /**
     * Store the liked shops in nearby page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function likenearby($id)
    {
        $find =   DB::table('likedshops')
                            ->where('shop_id', $id)
                            ->where('user_id',Auth::user()->id)
                            ->first();
        if($find){
            DB::table('likedshops')
                    ->where('shop_id', $id)
                    ->where('user_id',Auth::user()->id)
                    ->update(['liked' => 1]);
        }else{
            $likedshop = new likedshop();
            $likedshop->user_id = Auth::user()->id;
            $likedshop->shop_id = $id;
            $likedshop->liked = 1;
            $likedshop->save();

        }

        return redirect()->route('home.nearby');
        
        
    }

     /**
     * Remove the liked shops.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function remove($id)
    {
        DB::table('likedshops')
                    ->where('shop_id', $id)
                    ->where('user_id',Auth::user()->id)
                    ->update(['liked' => 0]);
        return redirect()->route('home');
        
        
    }


    /**
     * Show shops nearby.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function nearby()
    {
        $likedshops = DB::table('likedshops')
                                    ->select('shop_id')
                                    ->where('liked',1)
                                    ->where('user_id',Auth::user()->id)
                                    ->get();
        $data[] = 0;
        foreach($likedshops as $likedshop){
            $data[] = $likedshop->shop_id;
        }

        $lat = Auth::user()->lat;
        $lng = Auth::user()->lng;
        $shops = DB::table('shops')
                            ->select('*',DB::raw("( 6371 * acos( cos( RADIANS(?) ) * cos( RADIANS(shops.lat) ) * cos( RADIANS(shops.lng) - RADIANS(?)) + sin( RADIANS(?) ) * sin( RADIANS(shops.lat) ) )) AS distance"))
                            ->orderBy('distance')
                            ->setBindings([$lat, $lng, $lat])
                            ->whereNotIn('id',$data)
                            ->get();

        return view('nearby')
                    ->with('shops' , $shops);
    }

    /**
     * Store the location of users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function location(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        $user_id = Auth::user()->id;
        
        DB::table('users')
                    ->where('id', $user_id)
                    ->update(['lat' => $lat , 'lng' => $lng]);
        
        return response()->json('Done!');
    }

}
