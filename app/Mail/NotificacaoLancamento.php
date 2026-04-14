<?php

namespace App\Mail;

use App\Models\Lancamento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacaoLancamento extends Mailable
{
    use Queueable, SerializesModels;

    public $lancamento;
    public $acao;

    public function __construct(Lancamento $lancamento, $acao)
    {
        $this->lancamento = $lancamento;
        $this->acao = $acao;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lançamento ' . $this->acao . ': ' . $this->lancamento->descricao,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.lancamento',
        );
    }
}
