<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Painting;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;

class TicketController extends Controller
{
    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'course_id' => ['required', new In(Course::all()->pluck('id')->toArray())],
            'quantity' => 'numeric',
        ]);

        if (empty($validatedData['quantity'])) {
            $quantity = 1;
        } else {
            $quantity = $validatedData['quantity'];
        }

        $ticket = new Ticket([
            'course_id' => $request->get('course_id'),
            'quantity' => $quantity,
        ]);


        return response(json_encode($ticket->toArray()));
    }

    public function show($ticketId): Response
    {
        $ticket = Ticket::find($ticketId);

        $course = DB::table('courses')->where('id', $ticket->course_id)->first();

        $paintings = [];

        foreach (Painting::all() as $painting) {
            if ($painting->course_id === $course->id) {
                $paintings[] = $painting;
            }
        }

        return response(json_encode([
            'ticket' => $ticket,
            'course' => $course,
            'paintings' => $paintings
        ]));
    }
}
