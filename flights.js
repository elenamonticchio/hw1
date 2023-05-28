function goBack(event){
    const result = document.querySelector('#results-view');
    result.classList.add('hidden');

    const content = document.querySelector('#content');
    content.classList.remove('hidden');
}

function saveFlight(formData,like) {
    if (like.classList.contains('liked')) {
        like.src = './assets/heart.png';
        like.classList.remove('liked');
        fetch('remove_flight.php', { method: 'post', body: formData });
    } else {
        like.src='./assets/liked.png';
        like.classList.add('liked');
        fetch('save_flight.php', { method: 'POST', body: formData });
    }
}

function onResponse(response){
    return response.json();
}

function onFlightJson(json) {
    const result = json.data;

    const content = document.querySelector('#content');
    content.classList.add('hidden');

    const list = document.querySelector('#results-view');
    list.classList.remove('hidden');

    const container = document.querySelector('#container');
    container.innerHTML = '';

    const search = document.querySelector('.flight-search');

    if (result && result.length > 0) {
        for (const trip of result) {
            const itineraries = trip.itineraries;
            const trip_price = trip.price.total;
            const outward = trip.itineraries[0].segments;
            const back = trip.itineraries[1].segments;

            const flight = document.createElement('div');
            flight.classList.add('flight-offer');

            const left = document.createElement('div');
            left.classList.add('left');

            const right = document.createElement('div');
            right.classList.add('right');
            const price = document.createElement('span');
            price.textContent=trip_price + '€';
            const like = document.createElement('img');
            like.classList.add('like');
            like.src='./assets/heart.png';

            const outward_container = document.createElement('div');
            outward_container.classList.add('outward');
            const back_container = document.createElement('div');
            back_container.classList.add('return');

            const formData = new FormData();
            formData.append('trip_price', trip_price);

            for (const outwardSegment of outward) {
                const departureData = {};

                const departureDateTime = outwardSegment.departure.at;

                const departureAirport = outwardSegment.departure.iataCode;
                const departureTime = departureDateTime.split("T")[1].substring(0, 5);

                departureData.departureAirport = departureAirport;
                departureData.departureTime = departureTime;

                formData.append('outwardDeparture[]', JSON.stringify(departureData));

                const departureAirportSpan = document.createElement('span');
                departureAirportSpan.textContent = departureAirport;
                const departureTimeSpan = document.createElement('span');
                departureTimeSpan.textContent = departureTime;

                const departure = document.createElement('div');
                departure.classList.add('departure');
                departure.appendChild(departureAirportSpan);
                departure.appendChild(departureTimeSpan);

                const arrivalData = {};

                const arrivalDateTime = outwardSegment.arrival.at;

                const arrivalAirport = outwardSegment.arrival.iataCode;
                const arrivalTime = arrivalDateTime.split("T")[1].substring(0, 5);

                arrivalData.arrivalAirport = arrivalAirport;
                arrivalData.arrivalTime = arrivalTime;

                formData.append('outwardArrival[]', JSON.stringify(arrivalData));

                const arrivalAirportSpan = document.createElement('span');
                arrivalAirportSpan.textContent = arrivalAirport;
                const arrivalTimeSpan = document.createElement('span');
                arrivalTimeSpan.textContent = arrivalTime;

                const arrival = document.createElement('div');
                arrival.classList.add('arrival');
                arrival.appendChild(arrivalAirportSpan);
                arrival.appendChild(arrivalTimeSpan);

                const arrow = document.createElement('img');
                arrow.src = './assets/arrow.png';
                arrow.classList.add('arrow');

                const segment = document.createElement('div');
                segment.classList.add('segment');
                segment.appendChild(departure);
                segment.appendChild(arrow);
                segment.appendChild(arrival);
                outward_container.appendChild(segment);
            }

            for (const backSegment of back) {
                const departureData = {};

                const departureDateTime = backSegment.departure.at;
            
                const departureAirport = backSegment.departure.iataCode;
                const departureTime = departureDateTime.split("T")[1].substring(0, 5);

                departureData.departureAirport = departureAirport;
                departureData.departureTime = departureTime;

                formData.append('backDeparture[]', JSON.stringify(departureData));
            
                const departureAirportSpan = document.createElement('span');
                departureAirportSpan.textContent = departureAirport;
                const departureTimeSpan = document.createElement('span');
                departureTimeSpan.textContent = departureTime;
            
                const departure = document.createElement('div');
                departure.classList.add('departure');
                departure.appendChild(departureAirportSpan);
                departure.appendChild(departureTimeSpan);

                const arrivalData = {};
            
                const arrivalDateTime = backSegment.arrival.at;
            
                const arrivalAirport = backSegment.arrival.iataCode;
                const arrivalTime = arrivalDateTime.split("T")[1].substring(0, 5);

                arrivalData.arrivalAirport = arrivalAirport;
                arrivalData.arrivalTime = arrivalTime;

                formData.append('backArrival[]', JSON.stringify(arrivalData));
            
                const arrivalAirportSpan = document.createElement('span');
                arrivalAirportSpan.textContent = arrivalAirport;
                const arrivalTimeSpan = document.createElement('span');
                arrivalTimeSpan.textContent = arrivalTime;
            
                const arrival = document.createElement('div');
                arrival.classList.add('arrival');
                arrival.appendChild(arrivalAirportSpan);
                arrival.appendChild(arrivalTimeSpan);
            
                const arrow = document.createElement('img');
                arrow.src = './assets/arrow.png';
                arrow.classList.add('arrow');
            
                const segment = document.createElement('div');
                segment.classList.add('segment');
                segment.appendChild(departure);
                segment.appendChild(arrow);
                segment.appendChild(arrival);
                back_container.appendChild(segment);
            }
            
            right.appendChild(price);
            right.appendChild(like);

            left.appendChild(outward_container);
            left.appendChild(back_container);

            flight.appendChild(left);
            flight.appendChild(right);

            container.appendChild(flight);

            like.addEventListener('click', () => saveFlight(formData, like));
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

function searchFlight(event){
    const departure = document.getElementById("departure").value;
    const destination = document.getElementById("destination").value;
    const departureDate = document.getElementById("departure-date").value;
    const returnDate = document.getElementById("return-date").value;
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;

    const formData = new FormData();
    formData.append("departure", departure);
    formData.append("destination", destination);
    formData.append("departure-date", departureDate);
    formData.append("return-date", returnDate);
    formData.append("adults", adults);
    formData.append("children", children);

    fetch("search_flight.php", {method: 'post', body: formData}).then(onResponse).then(onFlightJson);
}

function insertDestination(event){
    const place = event.currentTarget;
    const input = document.querySelector('#destination');
    if(place.dataset.name === 'zanzibar'){
        input.value='zanzibar';
    }else if(place.dataset.name === 'positano'){
        input.value='napoli';
    }else if(place.dataset.name === 'cairo'){
        input.value='cairo';
    }else if(place.dataset.name === 'santorini'){
        input.value='fira';
    }        
    
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

document.querySelector('#submit').addEventListener('click',searchFlight);

const content = document.querySelectorAll('.image');
for (const element of content) {
  element.addEventListener('click', insertDestination);
}