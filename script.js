document.addEventListener("DOMContentLoaded", function () {
    let offset = 0;
    const limit = 20;
    const loadMoreBtn = document.getElementById("ver-mais");
    const resultsContainer = document.getElementById("resultados");

    function loadPsychologists(reset = false) {
        fetch(`fetch_psicologos.php?offset=${offset}&limit=${limit}`)
            .then(response => response.json())
            .then(data => {
                if (reset) {
                    resultsContainer.innerHTML = "";
                }
                data.forEach(pro => {
                    const card = document.createElement("div");
                    card.classList.add("col-md-12", "mb-3");
                    card.innerHTML = `
                        <div class="result-card p-4">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <img src="${pro.imagem}" class="rounded-circle profile-img me-3">
                                    <div>
                                        <p class="text-muted small mb-1">${pro.crp}</p>
                                        <p class="fw-bold">ABORDAGEM: ${pro.abordagem}</p>
                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <i class="fas fa-users text-secondary"></i>
                                            <span class="text-muted">${pro.publico}</span>
                                        </div>
                                        <div class="text-success fw-bold mt-2">💰 R$${pro.valor}</div>
                                    </div>
                                </div>
                                <a href="perfil.php?id=${pro.id}" class="text-decoration-none text-dark small fw-bold">VER PERFIL</a>
                            </div>
                            <h5 class="mt-3">${pro.nome}</h5>
                            <p class="text-muted">${pro.descricao}</p>
                            <div class="specialties badge">
                                ${pro.especialidades.map(specialty => `<span class="badge">${specialty}</span>`).join('')}
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="#" class="contact-btn">Entre em Contato</a>
                            </div>
                        </div>`;
                    resultsContainer.appendChild(card);
                });
                offset += limit;
            });
    }

    loadMoreBtn.addEventListener("click", function () {
        loadPsychologists();
    });

    loadPsychologists(true);
});

