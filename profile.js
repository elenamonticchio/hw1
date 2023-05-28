function removeLikeActivity(event){
    const activity= event.currentTarget.parentNode;

    const liked= event.currentTarget;

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

function onLikedActivity(json){
    const container = document.querySelector('#container');
    container.innerHTML= '';

    if (json.length === 0) {
        const noActivity = document.querySelector('#no-activity');

        const noResults = document.createElement('div');
        noResults.classList.add('noresults');
        noResults.textContent = 'Nessuna attività tra i preferiti';

        const home = document.createElement('a');
        home.textContent='Scopri le attività';
        home.href='home.php';

        noActivity.appendChild(noResults);
        noActivity.appendChild(home);
        return;
    }

    for(const result of json){
        const activity = document.createElement('div');
        activity.classList.add('activity');

        activity.dataset.id=result.activityId;        
        activity.dataset.name=result.name;
        activity.dataset.photo=result.photo;

        const bottom = document.createElement('div');
        bottom.classList.add('bottom');

        const picture = document.createElement('div');
        picture.classList.add('top');
        picture.style.background = `url(${result.photo}) center/cover no-repeat`;
        
        const title = document.createElement('h1');
        title.textContent=result.name;

        const like = document.createElement('img');
        like.classList.add('like');
        like.src='./assets/liked.png';
        like.classList.add('liked');
        like.addEventListener('click',removeLikeActivity);

        activity.appendChild(like);
        bottom.appendChild(title);
        activity.appendChild(picture);
        activity.appendChild(bottom);
        container.appendChild(activity);
    }
}

function onResponse(response){
    return response.json();
}

function findLikedActivity(){
    fetch('find_liked.php?q=activity').then(onResponse).then(onLikedActivity);
}

function removeLikeFlight(event){
    const flight= event.currentTarget.parentNode.parentNode;

    const liked= event.currentTarget;

    if (liked.classList.contains('liked')) {
        liked.src = './assets/heart.png';
        liked.classList.remove('liked');
        const formData = new FormData();
        formData.append('content',flight.dataset.content);
        fetch('remove_flight.php', { method: 'post', body: formData });
    } else {
        liked.src='./assets/liked.png';
        liked.classList.add('liked');
        const formData = new FormData();
        formData.append('content', flight.dataset.content);
        fetch('save_flight.php', { method: 'POST', body: formData });
    }

    event.stopPropagation();
}

function onLikedFlight(json) {
    const container = document.querySelector('#container2');
    container.innerHTML = '';

    if (json.length === 0) {
        const noFlight = document.querySelector('#no-flight');

        const noResults = document.createElement('div');
        noResults.classList.add('noresults');
        noResults.textContent = 'Nessun volo tra i preferiti';

        const flights = document.createElement('a');
        flights.textContent='Trova voli';
        flights.href='flights.php';

        noFlight.appendChild(noResults);
        noFlight.appendChild(flights);
        return;
    }

    for(let t=0; t<json.length;t++){
        const content = JSON.parse(json[t].content);

        const flight = document.createElement('div');
        flight.classList.add('flight-offer');
        flight.innerHTML='';

        const left = document.createElement('div');
        left.classList.add('left');

        const outward_container = document.createElement('div');
        outward_container.classList.add('outward');

        const back_container = document.createElement('div');
        back_container.classList.add('return');

        const right = document.createElement('div');
        right.classList.add('right');

        const price = document.createElement('span');
        price.textContent = content.trip_price + '€';

        const like = document.createElement('img');
        like.classList.add('likef');
        like.src = './assets/liked.png';
        like.classList.add('liked');

        flight.dataset.id = json[t].id;
        flight.dataset.content = json[t].content;

        for (let i = 0; i < content.outwardDeparture.length;) {
            for (let j = 0; j < content.outwardArrival.length; j++) {
                const segment = document.createElement('div');
                segment.classList.add('segment');

                const departure = document.createElement('div');
                departure.classList.add('departure');

                const arrival = document.createElement('div');
                arrival.classList.add('arrival');

                const arrow = document.createElement('img');
                arrow.src = './assets/arrow.png';
                arrow.classList.add('arrow');

                const outwardDeparture = JSON.parse(content.outwardDeparture[i]);
                const outwardArrival = JSON.parse(content.outwardArrival[j]);

                const departureAirportSpan = document.createElement('span');
                departureAirportSpan.textContent = outwardDeparture.departureAirport;

                const departureTimeSpan = document.createElement('span');
                departureTimeSpan.textContent = outwardDeparture.departureTime;

                departure.appendChild(departureAirportSpan);
                departure.appendChild(departureTimeSpan);

                const arrivalAirportSpan = document.createElement('span');
                arrivalAirportSpan.textContent = outwardArrival.arrivalAirport;

                const arrivalTimeSpan = document.createElement('span');
                arrivalTimeSpan.textContent = outwardArrival.arrivalTime;

                arrival.appendChild(arrivalAirportSpan);
                arrival.appendChild(arrivalTimeSpan);

                segment.appendChild(departure);
                segment.appendChild(arrow);
                segment.appendChild(arrival);

                outward_container.appendChild(segment);
                i++;
            }
        }

        for (let i = 0; i < content.backDeparture.length;) {
            for (let j = 0; j < content.backArrival.length; j++) {
                const segment = document.createElement('div');
                segment.classList.add('segment');

                const departure = document.createElement('div');
                departure.classList.add('departure');

                const arrival = document.createElement('div');
                arrival.classList.add('arrival');

                const arrow = document.createElement('img');
                arrow.src = './assets/arrow.png';
                arrow.classList.add('arrow');

                const backDeparture = JSON.parse(content.backDeparture[i]);
                const backArrival = JSON.parse(content.backArrival[j]);

                const departureAirportSpan = document.createElement('span');
                departureAirportSpan.textContent = backDeparture.departureAirport;

                const departureTimeSpan = document.createElement('span');
                departureTimeSpan.textContent = backDeparture.departureTime;

                departure.appendChild(departureAirportSpan);
                departure.appendChild(departureTimeSpan);

                const arrivalAirportSpan = document.createElement('span');
                arrivalAirportSpan.textContent = backArrival.arrivalAirport;

                const arrivalTimeSpan = document.createElement('span');
                arrivalTimeSpan.textContent = backArrival.arrivalTime;

                arrival.appendChild(arrivalAirportSpan);
                arrival.appendChild(arrivalTimeSpan);

                segment.appendChild(departure);
                segment.appendChild(arrow);
                segment.appendChild(arrival);

                back_container.appendChild(segment);
                i++;
            }
        }

        flight.appendChild(left);
        left.appendChild(outward_container);
        left.appendChild(back_container);
        right.appendChild(price);
        right.appendChild(like);
        flight.appendChild(right);
        container.appendChild(flight);
        like.addEventListener('click', removeLikeFlight);
    }
}

function findLikedFlight(){
    fetch('find_liked.php?q=flight').then(onResponse).then(onLikedFlight);
}

findLikedActivity();
findLikedFlight();