export const ACCEPTED_LOCALES = ['en', 'es'];
export const DEFAULT_LOCALE = 'es';

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
	for(let message of messages) {
		message.classList.add('d-none');
	}
};

export const validateContactForm = (event) => {
	let formValid = true;
	const inputs = document.getElementsByClassName('form-control');
	for(let input of inputs) {
		if(input.validity.valid === true) {
			document.getElementById(`${input.id}Message`).classList.add('d-none');
		} else {
			formValid = false;
			document.getElementById(`${input.id}Message`).classList.remove('d-none');
		}
	}

	event.preventDefault();
	if(formValid === true) {
		resetForm();
		console.log('all set!');
	} else {
		console.log('bad kitty');
	}
};

window.addEventListener('DOMContentLoaded', () => {
	document.getElementById('localeLink').addEventListener('click', switchLocale);
	document.getElementById('contactForm').addEventListener('submit', validateContactForm);
	document.getElementById('resetButton').addEventListener('click', resetForm);
	resetForm();
});
