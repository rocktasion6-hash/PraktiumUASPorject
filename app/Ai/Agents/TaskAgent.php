<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class TaskAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    public static function make(): self
    {
        return new self();
    }

    public function instructions(): Stringable|string
    {
        return <<<'INSTRUCTIONS'
        Anda adalah AI manajemen tugas.

        Tugas Anda:
        - Menganalisis tugas
        - Memberikan tingkat urgensi
        - Memberikan saran pengerjaan
        - Memberikan tips produktivitas

        Jawaban singkat, jelas, dan rapi.
        INSTRUCTIONS;
    }

    public function messages(): iterable
    {
        return [];
    }

    public function tools(): iterable
    {
        return [];
    }
}