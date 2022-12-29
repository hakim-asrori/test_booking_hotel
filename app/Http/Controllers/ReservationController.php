<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use App\Models\Type;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Payment;
use App\Repositories\CustomerRepository;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data['room_type'] = Type::get();
        return view('landing.reservation', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $transaksi = Transaction::create([
                'user_id'       => auth()->user()->id,
                'customer_id'   => Customer::where('user_id', auth()->user()->id)->first()->id,
                'room_id'       => $request->room,
                'check_in'      => $request->check_in,
                'check_out'     => $request->check_out,
                'status'        => 'Reservation',
            ]);

            $payment =  Payment::create([
                'user_id'       => auth()->user()->id,
                'transaction_id' => $transaksi->id,
                'status'        => 'Down Payment'
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e->getMessage());
        }

        return redirect('admin/dashboard')->with('success', 'Booking atas nama ' . auth()->user()->name . ' berhasil dibuat!');
    }
    public function roomAjax($type_id)
    {
        $data = Room::where('type_id', $type_id)->get();

        return response()->json($data);
    }

    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', ['customer' => $customer]);
    }

    public function update(Customer $customer, StoreCustomerRequest $request)
    {
        $customer->update($request->all());
        return redirect('customer')->with('success', 'customer ' . $customer->name . ' udpated!');
    }

    public function destroy(Customer $customer, ImageRepository $imageRepository)
    {
        try {
            $user = User::find($customer->user->id);
            $avatar_path = public_path('img/user/' . $user->name . '-' . $user->id);

            $customer->delete();
            $user->delete();

            if (is_dir($avatar_path)) {
                $imageRepository->destroy($avatar_path);
            }

            return redirect('customer')->with('success', 'Customer ' . $customer->name . ' deleted!');
        } catch (\Exception $e) {
            $errorMessage = "";
            if ($e->errorInfo[0] == "23000") {
                $errorMessage = "Data still connected to other tables";
            }
            return redirect('customer')->with('failed', 'Customer ' . $customer->name . ' cannot be deleted! ' . $errorMessage);
        }
    }
}
