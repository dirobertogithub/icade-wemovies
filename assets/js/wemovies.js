const sendHttpRequest = (method, url, data) => {
    const promise = new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url);


        xhr.onload = () => {
            if (xhr.status >= 400) {
                reject(xhr.response);
            } else {
                resolve(xhr.response);
            }
        };

        xhr.onerror = () => {
            reject('Erreur reponse');
        };

        xhr.send(data);
    });
    return promise;
};

const getDetails = (url) => {
    sendHttpRequest('GET', url).then(responseData => {
        let modalDiv = document.getElementById('modal-details');
        modalDiv.innerHTML = responseData;

        let myModal = new bootstrap.Modal(modalDiv, {});
            myModal.show();
    });
};

const getAutocomplete = (url) => {

    sendHttpRequest('GET', url).then(responseData => {
        let suggestion = document.getElementById('autocomplete-list');
        suggestion.innerHTML = responseData;
        suggestion.style.display = 'block';
    });
};

document.querySelectorAll('.btn-details').forEach(element => {
    element.addEventListener('click', event => {

        getDetails(event.target.getAttribute('data-url'));
    })
});


document.querySelectorAll('.gender-movie').forEach(element => {
    element.addEventListener('change', event => {

        document.getElementById("gender-form").submit();
    })
});

let autoInput = document.getElementById('myInput');
autoInput.addEventListener('keyup', function() {

   if(this.value !='') {
       let url = autoInput.getAttribute('data-url');
       let lastUrl = url.replace("keyUp", this.value);
       getAutocomplete(lastUrl);
   }else{
       let suggestion = document.getElementById('autocomplete-list');
       suggestion.innerHTML = '';
       suggestion.style.display = 'none';
   }
});

document.querySelectorAll('.suggestion-movies-div').forEach(element => {
    element.addEventListener('click', event => {
        e
        alert('la');
        getDetails(event.target.getAttribute('data-url'));
    })
});
