<?php

namespace Tests\Feature;


use App\Models\Course;
use App\Models\Painting;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_buy_ticket()
    {
        $course = factory(Course::class)->create();

        $response = $this->json('post', route('tickets.store'),[
            'course_id' => $course->id,
            'quantity' => 3,
        ]);

        $response->assertOk();

        $data = json_decode($response->getContent());

        $this->assertEquals($course->id, $data->course_id);
        $this->assertEquals('3', $data->quantity);
    }

    /** @test */
    public function default_quantity_for_tickets_is_one()
    {
        $course = factory(Course::class)->create();

        $response = $this->json('post', route('tickets.store'),[
            'course_id' => $course->id,
        ]);

        $response->assertOk();

        $data = json_decode($response->getContent());

        $this->assertEquals($course->id, $data->course_id);
        $this->assertEquals(1, $data->quantity);
    }

    /** @test */
    public function user_can_see_ticket_dettails()
    {
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();
        factory(Painting::class, 4)->create([
            'course_id' => $course->id,
        ]);

        $fakeCourse = factory(Course::class)->create();
        factory(Painting::class, 6)->create([
            'course_id' => $fakeCourse->id,
        ]);

        $ticket = factory(Ticket::class)->create([
            'course_id' => $course->id,
            'quantity' => 2,
        ]);

        $response = $this->json('get', route('tickets.show', compact('ticket')));

        $response->assertOk();

        $data = json_decode($response->getContent());

        tap($data->ticket, function ($returnedTicket) use ($course, $ticket) {
            $this->assertEquals($ticket->id, $returnedTicket->id);
            $this->assertEquals($course->id, $returnedTicket->course_id);
            $this->assertEquals(2, $returnedTicket->quantity);
        });

        $this->assertEquals(4, count($data->paintings));

        tap($data->course, function ($returnedCourse) use ($course) {
            $this->assertEquals($course->id, $returnedCourse->id);
        });
    }
}
