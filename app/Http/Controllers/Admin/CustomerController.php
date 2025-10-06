<?php
// app/Http/Controllers/Admin/CustomerController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(12)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'note'          => ['required','integer','between:0,5'],
            'title'         => ['required','string','max:255'],
            'comment'       => ['nullable','string','max:2000'],
            'customer_name' => ['required','string','max:255'],
        ]);
        Customer::create($data);
        return redirect()->route('admin.customers.index')->with('success','Client ajouté.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'note'          => ['required','integer','between:0,5'],
            'title'         => ['required','string','max:255'],
            'comment'       => ['nullable','string','max:2000'],
            'customer_name' => ['required','string','max:255'],
        ]);
        $customer->update($data);
        return back()->with('success','Client mis à jour.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('ok', 'Client supprimé.');
    }
}
