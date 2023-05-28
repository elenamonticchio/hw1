function goBack(event){
    const result = document.querySelector('#results-view');
    result.classList.add('hidden');

    const content = document.querySelector('#content');
    content.classList.remove('hidden');
}

function saveActivity(event){
    const liked = event.currentTarget;
    const activity = event.currentTarget.parentNode;

    if (liked.classList.contains('liked')) {
        liked.src = './assets/heart.png';
        liked.classList.remove('liked');
        const info = new FormData();
        info.append('id', activity.dataset.id);
        fetch('remove_activity.php', { method: 'post', body: info });
    } else {
        liked.src='./assets/liked.png';
        liked.classList.add('liked');
        const info = new FormData();
        info.append('id',activity.dataset.id);
        info.append('name',activity.dataset.name);
        info.append('photo',activity.dataset.photo);
        fetch("save_activity.php",{ method: 'post', body: info });
    }

    event.stopPropagation();
}

function onResponse(response){
    return response.json();
}

function onSearchJson(json){
    const content = document.querySelector('#content');
    content.classList.add('hidden');

    const list = document.querySelector('#results-view');
    list.classList.remove('hidden');

    const container = document.querySelector('#container');
    container.innerHTML = '';
    
    const results=json.data;

    if(results && results.length>0){
        let max;
        if(results.length>=6) max=6;
        else max=results.length;

        for(let i=0;i<max;i++){
            const id = results[i].id;
            const activity = results[i];
            const name = activity.name;
            const photo = activity.pictures[0];
            const amount = activity.price.amount;

            if(photo!== undefined && photo!=''){
                const div = document.createElement('div');
                div.classList.add('activity');
                div.dataset.id=id;
                div.dataset.name=name;
                div.dataset.photo=photo;

                const bottom = document.createElement('div');
                bottom.classList.add('bottom');

                const picture = document.createElement('div');
                picture.classList.add('top');
                picture.style.background = `url(${photo}) center/cover no-repeat`;
                
                const title = document.createElement('h1');
                title.textContent=name;

                const like = document.createElement('img');
                like.classList.add('like');
                like.src='./assets/heart.png';
                like.addEventListener('click',saveActivity);

                div.appendChild(like);
                bottom.appendChild(title);
                div.appendChild(picture);
                div.appendChild(bottom);
                container.appendChild(div);
            } else console.log('no photo');
        }
    } else {
        const noResultsMessage = document.createElement('div');
        noResultsMessage.textContent = 'Nessun risultato trovato.';
        noResultsMessage.classList.add('noresults');
        container.appendChild(noResultsMessage);
    }

    window.scrollTo({
        top: 550,
        behavior: 'smooth'
    });

    const back = document.querySelector('#back');
    back.addEventListener('click',goBack);
}

function search(event){
    const city = encodeURIComponent(document.querySelector('#city').value);

    fetch("search_activity.php?q=" + city).then(onResponse).then(onSearchJson);

    event.preventDefault();
}

function activity(event){
    const activity = event.currentTarget;
    const latitude = activity.dataset.latitude;
    const longitude = activity.dataset.longitude;
    
    fetch("search_content.php?latitude="+ latitude + "&longitude=" + longitude).then(onResponse).then(onSearchJson);
}

const searchBar = document.querySelector('form');
searchBar.addEventListener('submit',search);

const content = document.querySelectorAll('.image');
for (let i = 0; i < content.length; i++) {
  content[i].addEventListener('click', activity);
}