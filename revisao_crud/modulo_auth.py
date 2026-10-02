import database

def validar_credenciais(login, senha):
    try:
        conn = database.conectar()
        cursor = conn.cursor()

        query = "SELECT * FROM usuarios WHERE login = ? AND senha = ?"
        cursor.execute(query, (login, senha))

        usuario = cursor.fetchone()

        if usuario: 
            return dict(usuario)
        return None
    
    except Exception as e:
        print(f"\n[Erro interno] Falha ao consultar o banco de dados: {e}")
        return None
    
def login():
    while True:
        print("\n" + "=" * 45)
        print("                     LOGIN DE ACESSO")
        print("=" * 45)
        print("dICA: digite 'sair' no campo de login para encerrar.")

        login_input = input("Login: ").strip()
        
        if login_input.lower() == 'sair':
            return None
        
        senha_input = input("Senha: ").strip()

        if not login_input or not senha_input:
            print("\n[Falha] O motivo da falha é que os campos de login e senha não podem ficar vazios.")
            continue

        usuario_logado = validar_credenciais(login_input, senha_input)

        if usuario_logado:
            print(f"\nAutenticação realizada com sucesso!")
            return usuario_logado
        else:
            print("\n[Falha no Login] Motivo: Usuario não encontrado ou senha incorreta. Tente novamente.")