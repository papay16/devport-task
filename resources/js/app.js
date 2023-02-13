import './bootstrap';

const ifl_btn = document.getElementById('imfeelinglucky');
if (ifl_btn) {
    ifl_btn.addEventListener('click', (e) => {
        console.log(e);
        console.log('todo play attempt here');

        const hash = document.querySelector('.a_page input[name=link]').value;
        const table = document.querySelector('.a_page .table');

        table.classList.add('visually-hidden');

        window.axios.post(`/api/${hash}/play`)
            .then(resp => {
                const data = resp.data.data;
                table.querySelector('tbody').innerHTML = `<tr><td>${data.value}</td><td>${data.result}</td><td>${data.prize}</td></tr>`;
                table.classList.remove('visually-hidden');
            })
            .catch(err => {
                if (err.response) {
                    const data = err.response.data;
                    alert('Error: ' + data.message)
                }
            });
    });
}

const h_btn = document.getElementById('history');
if (h_btn) {
    h_btn.addEventListener('click', (e) => {
        console.log(e);
        console.log('todo history request here');

        const hash = document.querySelector('.a_page input[name=link]').value;
        const table = document.querySelector('.a_page .table');

        table.classList.add('visually-hidden');

        window.axios.post(`/api/${hash}/history`)
            .then(resp => {
                const data = resp.data.data;
                console.log(data);

                table.querySelector('tbody').innerHTML = data.map((attempt) => {
                    return `<tr><td>${attempt.value}</td><td>${attempt.result}</td><td>${attempt.prize}</td></tr>`;
                }).join('');
                table.classList.remove('visually-hidden');
            })
            .catch(err => {
                if (err.response) {
                    const data = err.response.data;
                    alert('Error: ' + data.message)
                }
            });
    });
}
