<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Lancamento;
use App\Models\User;

class LancamentoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Cria um usuário falso e faz o login para o teste não ser barrado
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    // --- TESTES DE TELA E ACESSO ---

    public function test_01_consegue_acessar_tela_de_listagem()
    {
        $response = $this->get('/lancamentos');
        $response->assertStatus(200);
    }

    public function test_02_consegue_acessar_tela_de_criacao()
    {
        $response = $this->get('/lancamentos/create');
        $response->assertStatus(200);
    }

    public function test_03_consegue_acessar_tela_de_edicao()
    {
        $lancamento = Lancamento::factory()->create();
        $response = $this->get("/lancamentos/{$lancamento->id}/edit");
        $response->assertStatus(200);
    }

    // --- TESTES DE CRUD NO BANCO DE DADOS ---

    public function test_04_consegue_salvar_novo_lancamento_no_banco()
    {
        $dados = [
            'descricao' => 'Teste de Receita',
            'data_lancamento' => '2026-04-15',
            'valor' => 1500.50,
            'tipo_lancamento' => 'Receita',
            'situacao' => 'Confirmado'
        ];
        $this->post('/lancamentos', $dados);
        $this->assertDatabaseHas('lancamentos', ['descricao' => 'Teste de Receita']);
    }

    public function test_05_consegue_atualizar_lancamento_existente()
    {
        $lancamento = Lancamento::create([
            'descricao' => 'Antiga', 'data_lancamento' => '2026-04-10', 
            'valor' => 100, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pendente'
        ]);
        
        $this->put("/lancamentos/{$lancamento->id}", array_merge($lancamento->toArray(), ['descricao' => 'Nova Descricao']));
        $this->assertDatabaseHas('lancamentos', ['descricao' => 'Nova Descricao']);
    }

    public function test_06_consegue_excluir_lancamento()
    {
        $lancamento = Lancamento::create([
            'descricao' => 'Apagar', 'data_lancamento' => '2026-04-10', 
            'valor' => 100, 'tipo_lancamento' => 'Despesa', 'situacao' => 'Pendente'
        ]);

        $this->delete("/lancamentos/{$lancamento->id}");
        $this->assertDatabaseMissing('lancamentos', ['id' => $lancamento->id]);
    }

    // --- TESTES DE REDIRECIONAMENTO ---

    public function test_07_redireciona_apos_salvar_com_sucesso()
    {
        $dados = ['descricao' => 'A', 'data_lancamento' => '2026-04-10', 'valor' => 10, 'tipo_lancamento' => 'Receita', 'situacao' => 'Pago'];
        $response = $this->post('/lancamentos', $dados);
        $response->assertRedirect('/lancamentos');
    }

    public function test_08_redireciona_apos_atualizar_com_sucesso()
    {
        $lancamento = Lancamento::create(['descricao' => 'A', 'data_lancamento' => '2026-04-10', 'valor' => 10, 'tipo_lancamento' => 'Receita', 'situacao' => 'Pago']);
        $response = $this->put("/lancamentos/{$lancamento->id}", $lancamento->toArray());
        $response->assertRedirect('/lancamentos');
    }

    public function test_09_redireciona_apos_excluir_com_sucesso()
    {
        $lancamento = Lancamento::create(['descricao' => 'A', 'data_lancamento' => '2026-04-10', 'valor' => 10, 'tipo_lancamento' => 'Receita', 'situacao' => 'Pago']);
        $response = $this->delete("/lancamentos/{$lancamento->id}");
        $response->assertRedirect('/lancamentos');
    }

    // --- TESTES DE VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS ---

    public function test_10_rejeita_cadastro_sem_descricao()
    {
        $response = $this->post('/lancamentos', ['valor' => 100]); // Faltando campos
        $response->assertSessionHasErrors('descricao');
    }

    public function test_11_rejeita_cadastro_sem_data()
    {
        $response = $this->post('/lancamentos', ['descricao' => 'A', 'valor' => 100]);
        $response->assertSessionHasErrors('data_lancamento');
    }

    public function test_12_rejeita_cadastro_sem_valor()
    {
        $response = $this->post('/lancamentos', ['descricao' => 'A']);
        $response->assertSessionHasErrors('valor');
    }

    public function test_13_rejeita_cadastro_sem_tipo()
    {
        $response = $this->post('/lancamentos', ['descricao' => 'A', 'valor' => 100]);
        $response->assertSessionHasErrors('tipo_lancamento');
    }

    public function test_14_rejeita_cadastro_sem_situacao()
    {
        $response = $this->post('/lancamentos', ['descricao' => 'A', 'valor' => 100]);
        $response->assertSessionHasErrors('situacao');
    }

    public function test_15_rejeita_valor_que_nao_seja_numero()
    {
        $response = $this->post('/lancamentos', ['descricao' => 'A', 'valor' => 'ABC', 'data_lancamento' => '2026-01-01', 'tipo_lancamento' => 'Receita', 'situacao' => 'Pago']);
        $response->assertSessionHasErrors('valor');
    }

    public function test_16_rejeita_descricao_maior_que_200_caracteres()
    {
        $descricaoGigante = str_repeat('A', 201);
        $response = $this->post('/lancamentos', ['descricao' => $descricaoGigante, 'valor' => 10, 'data_lancamento' => '2026-01-01', 'tipo_lancamento' => 'R', 'situacao' => 'P']);
        $response->assertSessionHasErrors('descricao');
    }

    // --- TESTES DOS REQUISITOS ADICIONAIS (FILTROS E PDF) ---

    public function test_17_filtro_por_data_inicial_funciona()
    {
        $response = $this->get('/lancamentos?data_inicio=2026-05-01');
        $response->assertStatus(200);
    }

    public function test_18_filtro_por_data_final_funciona()
    {
        $response = $this->get('/lancamentos?data_fim=2026-05-31');
        $response->assertStatus(200);
    }

    public function test_19_filtro_por_situacao_funciona()
    {
        $response = $this->get('/lancamentos?situacao=Pendente');
        $response->assertStatus(200);
    }

    public function test_20_exportacao_pdf_retorna_sucesso()
    {
        $response = $this->get('/lancamentos/export/pdf');
        $response->assertStatus(200);
    }
}
