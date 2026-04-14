<x-mail::message>
# Olá, Administrador!

Um lançamento foi **{{ $acao }}** no sistema de Gestão Financeira.

**Detalhes do Lançamento:**
- **Descrição:** {{ $lancamento->descricao }}
- **Data:** {{ \Carbon\Carbon::parse($lancamento->data_lancamento)->format('d/m/Y') }}
- **Valor:** R$ {{ number_format($lancamento->valor, 2, ',', '.') }}
- **Tipo:** {{ $lancamento->tipo_lancamento }}
- **Situação:** {{ $lancamento->situacao }}

<x-mail::button :url="url('/lancamentos')">
Acessar Sistema
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
