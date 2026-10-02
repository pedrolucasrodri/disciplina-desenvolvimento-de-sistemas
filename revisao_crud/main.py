import sys
import database
import modulo_auth
import modulo_produto
import modulo_estoque


def exibir_menu_principal(usuario_logado):
    while True:
        print("\n" + "=" * 45)
        print("             SISTEMA DE GESTÃO - SAEP")
        print("=" * 45)

        print(f" 👤 Usuario logado: {usuario_logado['nome']}\n")

        print("1. Cadastro e Gestão de Produtos")
        print("2. Gestão de Estoque")
        print("3. Fazer Logout")
        print("4. Encerrar Sistema")
        print("-" * 45)

        opcao = input("Escolha uma opção: ")

        if opcao == '1':
            modulo_produto.menu()
        
        elif opcao == '2':
            modulo_estoque()

        elif opcao == '3':
            print("\nRealizado logout...")

        elif opcao == '4':
            print("\nEncerrando o sistema. Até logo!")
            sys.exit(0)

        else:
            print("\[Erro] Opção inválida. Digite um número de 1 a 4")

def iniciar_sistema():
    print("Inicializando componentes do sistema...")

    database.inicializar_banco()

    while True:
        print("\n--- TELA DE ACESSO ---")

        usuario_logado = modulo_auth.login()

        if usuario_logado:
            exibir_menu_principal(usuario_logado)
        else:
            print("\nSistema encerrado.")
            break

if __name__ == "__main__":
    iniciar_sistema()