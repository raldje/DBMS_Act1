<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Productinfo;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $productinfos = Productinfo::paginate(10); // Adjust the number of items per page as needed
        return view('productinfos.index', compact('productinfos'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('productinfos.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Define validation rules to require all fields
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            // Add other validation rules for other fields as needed
        ];

        // Define custom validation messages
        $customMessages = [
            'name.required' => 'The product name is required.',
            'code.required' => 'The product code is required.',
            'quantity.required' => 'The product quantity is required.',
            'price.required' => 'The product price is required.',
        ];

        // Validate the input
        $this->validate($request, $rules, $customMessages);

        // If validation passes, continue with creating the record
        $input = $request->all();
        if (empty($input['productdescription'])) {
            $input['productdescription'] = 'No Description';
        }
        Productinfo::create($input);
        return redirect('productinfos')->with('flash_message', 'Student Added!');
    }


    public function show(string $id): View
    {
        $productinfos = Productinfo::find($id);
        return view('productinfos.show')->with('productinfos', $productinfos);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $productinfos = Productinfo::find($id);
        return view('productinfos.edit')->with('productinfos', $productinfos);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $productinfos = Productinfo::find($id);
        $input = $request->all();
        $productinfos->update($input);
        return redirect('productinfos')->with('flash_message', 'student Updated!');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Productinfo::destroy($id);
        return redirect('productinfos')->with('flash_message', 'Student deleted!');
        //
    }
}
