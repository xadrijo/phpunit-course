<?php

trait MailTracking
{
    protected $emails = [];

    public function setUpMailTracking()
    {
        Mail::getSwiftMailer()->registerPlugin(new TestingMailEventListener($this));
    }

    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty($this->emails, 'No emails have been sent.');

        return $this;
    }

    protected function seeEmailWasNotSent()
    {
        $this->assertEmpty($this->emails, 'Did not expect any emails to have been sent.');

        return $this;
    }

    protected function seeEmailEquals($body, Swift_Message $message = null)
    {
        $this->assertEquals($body, $this->getEmail($message)->getBody(), "No email with the provider body was sent.");

        return $this;
    }

    protected function seeEmailContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains($excerpt, $this->getEmail($message)->getBody(), "No email containing the provider body was found.");
    }

    protected function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);

        $this->assertCount($count, $this->emails, "Expected 2 emails to have been sent, but $emailsSent were.");

        return $this;
    }

    protected function seeEmailTo($recipient, Swift_Message $message = null)
    {
        $this->assertArrayHasKey($recipient, $this->getEmail($message)->getTo(), "No email was sent to $recipient.");

        return $this;
    }

    protected function seeEmailFrom($sender, Swift_Message $message = null)
    {
        $this->assertArrayHasKey($sender, $this->getEmail($message)->getFrom(), "No email was sent from $sender.");

        return $this;
    }

    public function addEmail(\Swift_Message $email)
    {
        $this->emails[] = $email;
    }

    protected function getEmail(Swift_Message $message = null)
    {
        $this->seeEmailWasSent();

        return $message ?: $this->lastEmail();
    }

    protected function lastEmail()
    {
        return end($this->emails);
    }
}

class TestingMailEventListener implements \Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event)
    {
        $this->test->addEmail($event->getMessage());
    }
}