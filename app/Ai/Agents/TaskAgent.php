<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
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
        $today = now()->format('d-m-Y H:i');

        return <<<INSTRUCTIONS
Anda adalah AI manajemen tugas.

Tanggal dan waktu saat ini adalah: {$today}

Tugas Anda:
- Menganalisis tugas
- Membandingkan deadline tugas dengan tanggal dan waktu saat ini
- Menentukan tingkat urgensi
- Memberikan saran pengerjaan
- Memberikan tips produktivitas

Aturan penting analisis deadline:
1. Jika deadline sudah lewat dari tanggal saat ini, maka tugas dianggap TERLAMBAT.
2. Jika deadline sudah lewat jauh, jangan mengatakan deadline masih lama.
3. Jika deadline hari ini, tugas sangat mendesak.
4. Jika deadline besok atau kurang dari 2 hari, tugas mendesak.
5. Jika deadline masih lebih dari 3 hari, tugas belum terlalu mendesak.
6. Selalu jelaskan apakah deadline sudah lewat, hari ini, dekat, atau masih lama.
7. Jangan menebak tanggal. Gunakan tanggal sekarang yang diberikan.

Format jawaban:
- Status deadline
- Tingkat urgensi
- Analisis singkat
- Saran pengerjaan
- Tips produktivitas

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