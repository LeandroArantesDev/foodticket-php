document.addEventListener("DOMContentLoaded", () => {
    const carrinho = [];
    const listaCarrinho = document.getElementById("lista-carrinho");
    const valorTotal = document.getElementById("valor-total");
    const formImprimir = document.getElementById("form-imprimir");
    const inputItens = document.getElementById("input-itens");
    const carrinhoLateral = document.getElementById("carrinho-lateral");
    const btnFecharCarrinho = carrinhoLateral.querySelector(".cabecalho button");

    // Adicionar produto ao carrinho
    document.querySelectorAll(".btn-adicionar-carrinho").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const nome = this.dataset.nome;
            const preco = parseFloat(this.dataset.preco);
            const quantidadeInput = this.parentElement.querySelector('input[type="text"]');
            const quantidade = parseInt(quantidadeInput.value) || 1;

            // Verifica se já existe no carrinho
            const existente = carrinho.find(item => item.id === id);
            if (existente) {
                existente.quantidade += quantidade;
            } else {
                carrinho.push({ id, nome, preco, quantidade });
            }

            atualizarCarrinho();

            // Ativa o carrinho lateral
            carrinhoLateral.classList.add("ativo");
        });
    });

    // Botão fechar carrinho
    btnFecharCarrinho.addEventListener("click", function () {
        carrinhoLateral.classList.remove("ativo");
    });

    // Ao imprimir, limpa o carrinho e recarrega a página
    formImprimir.addEventListener("submit", function () {
        setTimeout(() => {
            carrinho.length = 0; // esvazia o array
            atualizarCarrinho();
            window.location.reload();
        }, 500); // espera meio segundo para o submit abrir o PDF
    });

    // Atualiza a lista e o total
    function atualizarCarrinho() {
        listaCarrinho.innerHTML = "";
        let total = 0;
        carrinho.forEach((item, idx) => {
            const li = document.createElement("li");
            li.innerHTML = `
                <span>${item.nome} x${item.quantidade}</span>
                <div class="botoes">
                <span>R$ ${(item.preco * item.quantidade).toFixed(2).replace('.', ',')}</span>
                <button type="button" class="remover-item" data-idx="${idx}" title="Remover"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            `;
            listaCarrinho.appendChild(li);
            total += item.preco * item.quantidade;
        });
        valorTotal.textContent = "R$ " + total.toFixed(2).replace('.', ',');
        formImprimir.style.display = carrinho.length ? "block" : "none";
        inputItens.value = JSON.stringify(carrinho);

        // Remover item
        document.querySelectorAll(".remover-item").forEach(btn => {
            btn.addEventListener("click", function () {
                carrinho.splice(this.dataset.idx, 1);
                atualizarCarrinho();
            });
        });
    }
});