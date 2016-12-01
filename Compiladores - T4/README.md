### Analisador sintático e semântico de expressões aritméticas

- **Disciplina**: Compiladores
- **Autores**: Carlos Henrique Reis

### Sobre o projeto

Um analisador de expressões aritméticas, com suporte a precedência de operadores, operadores unários e binários e números de ponto
flutuante, podendo dar a saída em tokens do analisador léxico, e em árvore (sem notação polonesa reversa) do parser. O projeto foi escrito
100% manualmente e em PHP. O parser é *predictive top down recursive descent parser* baseada em uma gramática formal EBNF citada nos fontes.

### Uso do compilador

Tendo o PHP instalado, abra o prompt de comando, acesse a pasta `src` do projeto e use:

`php Compiler.php <tipo_analise> <tipo_entrada> <entrada>`

Onde:
- **`tipo_analise`** (`-l` ou `-p`) remete a qual camada fica encarregada a saída, se ao lexer, gerando os tokens, ou ao parser, gerando
a árvore de sintaxe abstrata infixa.
- **`tipo_entrada`** (`-f` ou `-t`) remete ao tipo de entrada. `-f` para arquivo e `-t` para texto.
- **`entrada`** remete à fonte de análise, que pode ser uma expressão ou o nome de um arquivo.

Exemplos de uso:

`php Compiler.php -l -f arquivo.txt`
`php Compiler.php -p -t "1 + 1 * (2 - -4) / 3; 2 + 2;"`
