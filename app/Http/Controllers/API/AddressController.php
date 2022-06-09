<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Address;

class AddressController extends Controller
{
    public function __construct(Address $address)
    {
        $this->address = $address;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->address->latest()->get();
        return response()->json([$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'address' => 'required|string|max:255',
            'city' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        try{
            $address = $this->address->create([
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code
             ]);
            
            return response()->json(['Address created successfully.',$address]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::find($id);
        if (is_null($address)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([$address]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $validator = Validator::make($request->all(),[
            'address' => 'required|string|max:255',
            'city' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        try{
            $data_address =[
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code
            ];
    
            $address = $this->address->updateOrCreate(
                [
                    'id' => $address->id
                ],
                $data_address
            );
            
            return response()->json(['Address updated successfully.', $address]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = $this->address->find($id);
        if($address){
            $address->delete();
            return response()->json('Address deleted successfully');
        } else {
            return response()->json('Address does not exist');
        }
    }
}
