<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailerTest extends TestCase
{
    use \MailTracking;

    public function setUp()
    {
        parent::setUp();
        $this->setUpMailTracking();
    }

    public function testBasicTest()
    {
        Mail::raw('Hello World', function ($message) {
            $message->to('foo@bar.com');
            $message->from('bar@foo.com');
        });

        //$this->seeEmailTo('foo@bar.com')->seeEmailFrom('bar@foo.com');
        //$this->seeEmailWasNotSent();
        $this->seeEmailEquals("Hello World")->seeEmailContains("Hello");
    }


}


