# Click History Report
*Desafio:* Crie um plugin que adicione um comando ao WP-CLI que imprima um relatório de histórico de registros. Esse relatório pode ser apenas a listagem das últimas entradas com seus respectivos.

## Descrição

O plugin Click History Report permite que você gere relatórios do histórico de cliques no botão do plugin Click Counter Button através da interface de linha de comando (CLI) do WordPress (WP-CLI).

## Instalação

1. Baixe o arquivo ZIP do plugin.
2. Faça upload e ative o plugin por meio do painel de administração do WordPress.

## Uso

### Comando do WP-CLI

Para gerar um relatório do histórico de cliques, utilize o seguinte comando no terminal:

```bash
wp cc report <limite> [--order=<ordem>]
```

Substitua <limite> pelo número desejado de registros a serem exibidos.

### Opções do Comando do WP-CLI

* <limite>: O limite de registros a serem exibidos.
* --order: A ordem para mostrar os registros (ASC ou DESC).

#### Exemplo

```bash
wp cc report 10 --order=DESC
```

Isso exibirá os últimos 10 registros de cliques em ordem decrescente.