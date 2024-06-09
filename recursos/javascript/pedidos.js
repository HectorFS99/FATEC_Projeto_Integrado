function avaliar() {
    popupSwal.fire({ 
        title: `O que você achou?`
        , icon: 'question'
        , html: `
        <section>
            <div id="radio-2" class="star-rate">
                <input type="radio" id="star-check-1" class="star-check" name="stars-2" />
                <input type="radio" id="star-check-2" class="star-check" name="stars-2" />
                <input type="radio" id="star-check-3" class="star-check" name="stars-2" />
                <input type="radio" id="star-check-4" class="star-check" name="stars-2" />
                <input type="radio" id="star-check-5" class="star-check" name="stars-2" />
                <div class="stars">
                    <label for="star-check-1"><i data-star-value="1" class="fa fa-star"></i></label>
                    <label for="star-check-2"><i data-star-value="2" class="fa fa-star"></i></label>
                    <label for="star-check-3"><i data-star-value="3" class="fa fa-star"></i></label>
                    <label for="star-check-4"><i data-star-value="4" class="fa fa-star"></i></label>
                    <label for="star-check-5"><i data-star-value="5" class="fa fa-star"></i></label>
                </div>
            </div>
        </section>
        <div class="mb-3">
            <textarea id="txtComentario" rows="3"></textarea>
        </div>
        <small>
            A sua avaliação será revisada pela nossa equipe, antes de ficar visível para o público.
        </small>`
        , showCancelButton: true
        , confirmButtonText: "OK"
        , cancelButtonText: "Cancelar"
        , reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            var algumRadioMarcado = document.querySelector('input[name="stars-2"]:checked') !== null;
            if (algumRadioMarcado) {
                popupSwal.fire("Obrigado por avaliar!", "A sua avaliação será analisada. Iremos te avisar via e-mail quando estiver publicada.", "success");

                var btnAvaliar = document.getElementById('btnAvaliar');
                btnAvaliar.innerHTML = 'Avaliação em análise';
                
                btnAvaliar.classList.replace('btn-detalhes_ped', 'btn-secondary');
                btnAvaliar.classList.add('disabled');
            } else {
                popupSwal.fire({ 
                    title: "Por favor, selecione alguma estrela."
                    , icon: "warning"
                    , confirmButtonText: "OK"
                }).then(() => {
                    avaliar();
                });
            }        
        }
    });
}