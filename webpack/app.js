import loadGoogleMapsApi from 'load-google-maps-api';

export const ACCEPTED_LOCALES = ['en', 'es'];
export const DEFAULT_LOCALE = 'es';
export const GOOGLE_PLACE_ID = 'ChIJNWKkTXaT2IARSA8NwRnkA3Y';

export class GoogleMap {
	constructor(newKey, newLibraries = []) {
		this.key = newKey;
		this.libraries = newLibraries;
	}

	loadGoogleMapsApi() {
		return loadGoogleMapsApi({ key: this.key, libraries: this.libraries });
	}

	getPlaceDetails(googleMaps, googleMap) {
		return (place, status) => {
			if (status === googleMaps.places.PlacesServiceStatus.OK) {
				const marker = new googleMaps.Marker({
					map: googleMap,
					position: place.geometry.location
				});
				googleMaps.event.addListener(marker, 'click', () => {
					const infowindow = new googleMaps.InfoWindow();
					const phoneHref = place.international_phone_number.replace(/ /g, '');
					infowindow.setPosition(place.geometry.location);
					infowindow.setContent(`<div><h6>${place.name}</h6><p>${place.formatted_address}<br /><a href="tel:${phoneHref}">${place.formatted_phone_number}</a></p></div>`);
					infowindow.open(googleMap);
				});
				googleMap.setCenter(place.geometry.location);
			}
		};
	}

	createMap(googleMaps, mapElement) {
		const center = { lat: 32.5228039, lng: -117.0174018 };
		const placesRequest = {
			placeId: GOOGLE_PLACE_ID,
			fields: ['name', 'formatted_address', 'formatted_phone_number', 'geometry', 'international_phone_number']
		};
		this.map = new googleMaps.Map(mapElement, {
			center,
			zoom: 18
		});
		const placesService = new googleMaps.places.PlacesService(this.map);
		googleMaps.event.addDomListener(this.map, 'resize', this.map.setCenter(center));
		placesService.getDetails(placesRequest, this.getPlaceDetails(googleMaps, this.map));
	}
}
export const googleMap = new GoogleMap('AIzaSyBcJULSuDwzw6Fu-nocSDMR88pOvbHAuuQ', ['places']);

export const switchLocale = () => {
	const locale = Cookies.get('locale') || DEFAULT_LOCALE;
	const newLocale = ACCEPTED_LOCALES.find(currLocale => currLocale !== locale);
	fetch('/api/locale/', {
		method: 'POST',
		body: JSON.stringify({locale: newLocale}),
		headers: new Headers({
			'Content-type': 'application/json',
			'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
		})
	})
		.then(reply => reply.json())
		.then((reply) => {
			if(reply.status === 200) {
				Cookies.set('locale', newLocale, {expires: 30, path: '/'});
				window.location.reload();
			}
		});
};

export const resetForm = () => {
	const messages = document.getElementsByClassName('message');
	document.getElementById('contactForm').reset();
	document.getElementById('outputArea').classList.add('d-none');
	for(let message of messages) {
		message.classList.add('d-none');
	}
};

export const updateFormOutput = (contextualClass, message) => {
	const outputArea = document.getElementById('outputArea');
	outputArea.classList.remove('alert-success', 'alert-danger', 'd-none');
	outputArea.classList.add(contextualClass);
	outputArea.innerText = message;
};

export const validateContactForm = (event) => {
	let formValid = true;
	const contactFormInputs = {};
	const inputs = document.getElementsByClassName('form-control');
	for(let input of inputs) {
		if(input.validity.valid === true) {
			document.getElementById(`${input.id}Message`).classList.add('d-none');
			contactFormInputs[input.id] = input.value;
		} else {
			formValid = false;
			document.getElementById(`${input.id}Message`).classList.remove('d-none');
		}
	}

	event.preventDefault();
	if(formValid === true) {
		contactFormInputs.recaptcha = grecaptcha.getResponse();
		fetch('/api/mail/', {
			method: 'POST',
			body: JSON.stringify(contactFormInputs),
			headers: new Headers({
				'Content-type': 'application/json',
				'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
			})
		}).then(httpReply => {
			resetForm();
			if(httpReply.ok === true) {
				httpReply.json().then(reply => {
					const contextualClass = reply.status === 200 ? 'alert-success' : 'alert-danger';
					updateFormOutput(contextualClass, reply.message);
				});
			} else {
				updateFormOutput('alert-danger', `Unable to send mail: HTTP ${httpReply.status} ${httpReply.statusText}`);
			}
		});
	}
};

export const resize = () => {
	const center = { lat: 32.5228039, lng: -117.0174018 };
	const mainContainer = document.getElementById('mainContainer');
	const mainWidth = mainContainer.offsetWidth;
	const mapWidth = Math.floor(0.95 * mainWidth);
	const mapElement = document.getElementById('googleMap');
	mapElement.style.height = `${mapWidth}px`;
	mapElement.style.width = `${mapWidth}px`;
};

window.addEventListener('DOMContentLoaded', () => {
	let mapElement = document.getElementById('googleMap');
	googleMap.loadGoogleMapsApi().then(googleMaps => googleMap.createMap(googleMaps, mapElement));

	document.getElementById('localeLink').addEventListener('click', switchLocale);
	document.getElementById('contactForm').addEventListener('submit', validateContactForm);
	document.getElementById('resetButton').addEventListener('click', resetForm);
	resetForm();
});

window.addEventListener('resize', resize);
window.addEventListener('load', resize);
