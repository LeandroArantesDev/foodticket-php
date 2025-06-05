document.addEventListener("DOMContentLoaded", function () {
    // Impede números no campo nome
    document.querySelectorAll('input[name="nome"]').forEach(function (input) {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[0-9]/g, "");
        });
    });

    // Validação ao enviar o formulário
    document.querySelectorAll("form").forEach(function (form) {
        form.addEventListener("submit", function (e) {
            let valido = true;
            let mensagens = [];

            // Nome: sem números, mínimo 3 letras
            let nome = form.querySelector('input[name="nome"]');
            if (nome && !/^[A-Za-zÀ-ÿ\s\-]{3,}$/.test(nome.value.trim())) {
                valido = false;
                mensagens.push("O nome deve ter pelo menos 3 letras e não pode conter números.");
            }

            // E-mail
            let email = form.querySelector('input[type="email"]');
            if (email && !/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i.test(email.value.trim())) {
                valido = false;
                mensagens.push("Insira um e-mail válido.");
            }

            // Senha (mínimo 6 caracteres, pode ajustar para 8 e regras mais fortes se quiser)
            let senha = form.querySelector('input[type="password"]');
            if (senha && senha.value.length < 6) {
                valido = false;
                mensagens.push("A senha deve conter no mínimo 6 caracteres.");
            }

            // Se não for válido, impede o envio e mostra alertas
            if (!valido) {
                e.preventDefault();
                alert(mensagens.join("\n"));
            }
        });
    });
});