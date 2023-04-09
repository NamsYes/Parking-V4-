<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

class ReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user')->get();

        return view('reservations', [
            'reservations' => $reservations
        ]);
    }

    public function create()
    {
        $users = User::doesntHave('reservation')->get();
        $places = Place::doesntHave('Reservation')->get();

        return view('createReservation', [
            'users' => $users,
            'places' => $places,

        ]);
    }

    public function store(Request $request)
    {
        $reservation = new Reservation;

        $reservation->user_id = request('user');
        $reservation->place_id = request('place');
        $reservation->created_at = request('date_debut');
        $reservation->end_at = request('date_fin');

        $reservation->save();

        return redirect()->route('reservations')
            ->with('success La reservation a été créer !');
    }

    public function edit($id)
    {
        $reservation = Reservation::find($id);

        return view('editReservation', [
            'reservation' => $reservation
        ]);
    }

    public function update($id)
    {
        $reservation = Reservation::find($id);

        $reservation->user_id = request('user');
        $reservation->place_id = request('place');
        $reservation->created_at = request('date_debut');
        $reservation->end_at = request('date_fin');

        $reservation->save();

        return redirect()->route('reservations')
            ->with('success La reservation a été créer !');
    }

    public function delete($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations')
            ->with('success, la reservation a bien été supprimé');
    }
}
