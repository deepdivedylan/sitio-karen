import 'popper.js';
import 'jquery';
import 'bootstrap';
import 'js-cookie';

// loading FontAwesome like this reduces page loads by 1 MB :scream_cat:
import { dom, library } from '@fortawesome/fontawesome-svg-core';
import { faBalanceScale, faBars, faHandshake, faPassport } from '@fortawesome/free-solid-svg-icons';
library.add(faBalanceScale);
library.add(faBars);
library.add(faHandshake);
library.add(faPassport);
dom.watch();