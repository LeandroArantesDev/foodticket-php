document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('input[name="nome"]').forEach(function (input) {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[0-9]/g, "");
        });
    });

    document.querySelectorAll("form").forEach(function (form) {
        form.addEventListener("submit", function (e) {
            let valido = true;
            let mensagens = [];

            let nome = form.querySelector('input[name="nome"]');
            if (nome && !/^[A-Za-zÀ-ÿ\s\-]{3,}$/.test(nome.value.trim())) {
                valido = false;
                mensagens.push("O nome deve ter pelo menos 3 letras e não pode conter números.");
            }

            let email = form.querySelector('input[type="email"]');
            if (email && !/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i.test(email.value.trim())) {
                valido = false;
                mensagens.push("Insira um e-mail válido.");
            }

            let senha = form.querySelector('input[type="password"]');
            if (senha && senha.value.length < 6) {
                valido = false;
                mensagens.push("A senha deve conter no mínimo 6 caracteres.");
            }

            if (!valido) {
                e.preventDefault();
                alert(mensagens.join("\n"));
            } else {
                const btn_form = form.querySelector("button[type='submit'],button:not([type])");
                if (btn_form) {
                    btn_form.disabled = true;
                }
            }
        });
    });
});