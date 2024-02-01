document.addEventListener('DOMContentLoaded', () => {

    console.log('Script Connected');

    const submitBtn = document.getElementById('submit');
    const form = document.getElementById('form_to_submit');

    if (submitBtn && form) {

        let requiredInputs = form.querySelectorAll('.required');

        requiredInputs.forEach((input) => {
            input.addEventListener('input', () => {
                if (input.value.length >= 1) {
                    if (input.classList.contains('is-invalid')) {
                        input.classList.remove('is-invalid');
                    }
                }
            })
        });

        submitBtn.addEventListener('click', (e) => {
            e.preventDefault();

            let ready = true;

            requiredInputs.forEach((input) => {
                if (input.value === '') {
                    input.classList.add('is-invalid');
                    ready = false;
                }
            });

            const password = form.querySelector('#password').value;
            if (ready) {
                if (password === 'basic') {

                    submitBtn.value = 'В процессе...';
                    submitBtn.setAttribute("disabled", "disabled");

                    fetch('/wp-content/plugins/basic-post-ajax/insert-post-to-bd.php', {
                        method: 'POST',
                        body: new FormData(form)
                    })
                        .then((response) => {
                            return response.text();
                        })
                        .then((result) => {
                            console.log(result);
                            alert('Объект опубликован!');
                            let allInputs = form.querySelectorAll('input');
                            allInputs.forEach((input) => {
                                input.value = '';
                            });
                            submitBtn.value = 'Отправить';
                            submitBtn.removeAttribute("disabled");
                        });
                } else {
                    alert('Неверный пароль');
                }
            }
        });
    }

});